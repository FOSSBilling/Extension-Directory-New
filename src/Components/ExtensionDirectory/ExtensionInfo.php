<?php

namespace ExtensionDirectory;

use League\CommonMark\GithubFlavoredMarkdownConverter;
use ElGigi\CommonMarkEmoji\EmojiExtension;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class ExtensionInfo
{
    public static function getAllExtensions(bool $convertReadme = true): array
    {
        $extensionList = Tools::getFileList(BASE_PATH . DIRECTORY_SEPARATOR . 'Library' . DIRECTORY_SEPARATOR . 'Extensions', 'php');
        $extensions = [];
        foreach ($extensionList as $extension) {
            $extension = basename($extension, ".php");
            $info = self::getExtensionInfo($extension, $convertReadme);
            if ($info) {
                $extensions[] = $info;
            }
        }

        return $extensions;
    }

    public static function getExtensionInfo(string $id, bool $convertReadme = true): array
    {
        $id = strtolower($id);
        $FQCN = '\\ExtensionDirectory\\Extensions\\' . $id;
        if (!class_exists($FQCN)) {
            return [];
        }

        $cache = new FilesystemAdapter('extInfo', 3600, PATH_CACHE);
        $key = $convertReadme ? $id . '.converted' : $id . 'notConverted';
        return $cache->get($key, function (ItemInterface $item) use ($FQCN, $id, $convertReadme): array {
            $extension = new $FQCN;

            // Fetch the extension's readme
            if ($extension::readmeUrl) {
                $readme = file_get_contents($extension::readmeUrl);

                // If desired, convert it to HTML
                if ($convertReadme) {
                    $converter = new GithubFlavoredMarkdownConverter([
                        'extensions' => [
                            new EmojiExtension(),
                        ],
                    ]);

                    $readme = $converter->convert($readme);
                }
            } else {
                $readme = '<h1>Extension readme</h1> <br/> <p>This extension does not have a readme.</p>';
            }

            // Sort the versions
            $releases = $extension::releases;
            usort($releases, function ($a, $b) {
                return version_compare($b['tag'], $a['tag']);
            });

            $downloadURL = 

            // Pull in SPDX info if needed to complete the license info
            $license = Tools::completeLicenseInfo($extension::license);

            return [
                'id'          => $id,
                'type'        => $extension::type,
                'name'         => $extension::name,
                'description'  => $extension::description,
                'version'      => $releases[0]['tag'],
                'download_url' => $releases[0]['download_url'],
                'releases'     => $releases,
                'author'       => Tools::returnAuthorInfo($extension::author),
                'license'      => $license,
                'source'       => Tools::getRepoInfo($extension::source),
                'icon_url'     => $extension::icon_url,
                'website'      => $extension::website,
                'readme'       => $readme,
            ];
        });
    }
}
