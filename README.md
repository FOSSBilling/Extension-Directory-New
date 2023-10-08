# FOSSBilling extension directory

This is a new version of the Extension Directory that is running on PHP. Things are likely to change, it's mostly just a POC.
All basic functionality from the original extension directory is now implemented, so it should work in-place of the other one.

## Running a dev instance

1. Ensure you have the necessary composer packages installed by doing `composer install` from the root directory
2. Move to the `src` directory by doing `cd src`
3. Start the dev server by doing `php -S localhost:8000`
4. Periodically clear the `src/Cache` directory as cache isn't automatically disabled during during development yet

## Adding a new extension or author

- All extensions are stored under `src/Library/Extensions`.
- All authors are stored under `src/Library/Authors`.

## License
Each module is licensed under the terms set by the author. Please see the `LICENSE` file in each module for more information.
The extension directory website is licensed under the Apache 2.0 license. See the `LICENSE` file for more information.
