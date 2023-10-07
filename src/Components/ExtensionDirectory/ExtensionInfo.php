<?php

namespace ExtensionDirectory;

use League\CommonMark\GithubFlavoredMarkdownConverter;
use ElGigi\CommonMarkEmoji\EmojiExtension;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class ExtensionInfo
{
    public static function getAllExtensions(): array
    {
        $extensionList = Tools::getFileList(BASE_PATH . DIRECTORY_SEPARATOR . 'Library' . DIRECTORY_SEPARATOR . 'Extensions', 'php');
        $extensions = [];
        foreach ($extensionList as $extension) {
            $extension = basename($extension, ".php");
            $info = self::getExtensionInfo($extension);
            if ($info) {
                $extensions[] = $info;
            }
        }

        return $extensions;
    }

    public static function getExtensionInfo(string $id): array
    {
        $id = strtolower($id);
        $FQCN = '\\ExtensionDirectory\\Extensions\\' . $id;
        if (!class_exists($FQCN)) {
            return [];
        }

        $cache = new FilesystemAdapter('extInfo', 3600, PATH_CACHE);
        return $cache->get($id, function (ItemInterface $item) use ($FQCN, $id): array {
            $extension = new $FQCN;
            if ($extension::readmeUrl) {
                // Fetch the README
                $readme = file_get_contents($extension::readmeUrl);

                // Parse the README to HTML
                $converter = new GithubFlavoredMarkdownConverter([
                    'extensions' => [
                        new EmojiExtension(),
                    ],
                ]);

                $readmeHtml = $converter->convert($readme);
            } else {
                $readmeHtml = '<h1>Extension readme</h1> <br/> <p>This extension does not have a readme.</p>';
            }

            return [
                'displayName' => $extension::displayName,
                'type'        => $extension::type,
                'description' => $extension::description,
                'license'     => $extension::license,
                'readme'      => $readmeHtml,
                'source'      => $extension::source,
                'website'     => $extension::website,
                'icon_url'    => $extension::icon_url,
                'releases'    => $extension::releases,
                'id'          => strtolower($id),
            ];
        });
    }
}
