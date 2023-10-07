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

            // Fetch the extension's readme and convert it to HTML
            if ($extension::readmeUrl) {
                $readme = file_get_contents($extension::readmeUrl);
                $converter = new GithubFlavoredMarkdownConverter([
                    'extensions' => [
                        new EmojiExtension(),
                    ],
                ]);

                $readmeHtml = $converter->convert($readme);
            } else {
                $readmeHtml = '<h1>Extension readme</h1> <br/> <p>This extension does not have a readme.</p>';
            }

            // Sort the versions
            $releases = $extension::releases;
            usort($releases, function ($a, $b) {
                return version_compare($b['tag'], $a['tag']);
            });

            // Pull in SPDX info if needed to complete the license info
            $license = Tools::completeLicenseInfo($extension::license);

            return [
                'displayName' => $extension::displayName,
                'type'        => $extension::type,
                'description' => $extension::description,
                'license'     => $license,
                'readme'      => $readmeHtml,
                'source'      => Tools::getRepoInfo($extension::source),
                'website'     => $extension::website,
                'icon_url'    => $extension::icon_url,
                'releases'    => $releases,
                'id'          => $id,
                'author'      => Tools::returnAuthorInfo($extension::author),
            ];
        });
    }
}
