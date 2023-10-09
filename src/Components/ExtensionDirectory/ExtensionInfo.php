<?php

namespace ExtensionDirectory;

use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Extension\DefaultAttributes\DefaultAttributesExtension;
use League\CommonMark\Extension\Table\Table;
use League\CommonMark\Extension\CommonMark\Node\Block\BlockQuote;
use League\CommonMark\GithubFlavoredMarkdownConverter;
use ElGigi\CommonMarkEmoji\EmojiExtension;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\Finder\Finder;

class ExtensionInfo
{

    public static function getAllExtensions(bool $convertReadme = true, object $cacheService): array
    {
        $finder = new Finder();
        $finder->files()->in(BASE_PATH . DIRECTORY_SEPARATOR . 'Library' . DIRECTORY_SEPARATOR . 'Extensions')->name('*.php');

        $extensions = [];
        foreach ($finder as $file) {
            $extension = $file->getBasename('.php');
            $info = self::getExtensionInfo($extension, $convertReadme, $cacheService);
            if ($info) {
                $extensions[] = $info;
            }
        }

        return $extensions;
    }

    public static function getExtensionInfo(string $id, bool $convertReadme = true, object $cacheService): array
    {
        // Convert the ID to lowercase and build the fully qualified class name
        $id = strtolower($id);
        $FQCN = '\\ExtensionDirectory\\Extensions\\' . $id;

        // If the class doesn't exist, return an empty array
        if (!class_exists($FQCN)) {
            return [];
        }

        // Instantiate the extension class
        $extension = new $FQCN;

        // Determine the cache key based on whether or not the readme should be converted to HTML
        $key = $convertReadme ? $id . 'converted' : $id . 'notConverted';

        // Retrieve the readme from the cache, or generate it and cache it if it doesn't exist
        $readme = $cacheService->get($key, function (ItemInterface $item) use ($extension, $convertReadme): string {
            // Set the cache expiration time to one day
            $item->expiresAfter(86400);

            // Attempt to retrieve the readme from the URL specified in the extension class
            $readme = 'There was an issue retrieving the module\'s readme.';
            if ($extension::readmeUrl) {
                $readme = file_get_contents($extension::readmeUrl);
            }

            // If desired, convert the readme to HTML
            if ($convertReadme) {
                $converter = new GithubFlavoredMarkdownConverter([
                    'extensions' => [
                        new EmojiExtension(),
                        new DefaultAttributesExtension(),
                    ],
                    'default_attributes' => [
                        Table::class => [
                            'class' => 'table table-hover',
                        ],
                        Image::class => [
                            'class' => 'img-fluid',
                        ],
                        BlockQuote::class => [
                            'class' => 'blockquote',
                        ],
                    ],
                    'html_input' => 'strip',
                    'max_nesting_level' => 25,
                    'allow_unsafe_links' => false,
                ]);

                return $converter->convert($readme);
            } else {
                return $readme;
            }
        });

        // Sort the releases by version number in descending order
        $releases = $extension::releases;
        usort($releases, function ($a, $b) {
            return version_compare($b['tag'], $a['tag']);
        });

        // Complete the license information using the SPDX API if necessary
        $license = Tools::completeLicenseInfo($extension::license, $cacheService);

        // Build and return an array of extension information
        return [
            'id'           => $id,
            'type'         => $extension::type,
            'name'         => $extension::name,
            'description'  => $extension::description,
            'version'      => $releases[0]['tag'],
            'download_url' => $releases[0]['download_url'],
            'releases'     => $releases,
            'author'       => Tools::returnAuthorInfo($extension::author),
            'license'      => $license,
            'repo'         => $extension::repo,
            'icon_url'     => $extension::icon_url,
            'website'      => $extension::website,
            'readme'       => $readme,
        ];
    }
}
