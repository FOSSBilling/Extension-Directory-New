# FOSSBilling extension directory

This is a new version of the Extension Directory that is running on PHP. Things are likely to change, it's mostly just a POC.
All basic functionality from the original extension directory is now implemented, so it should work in-place of the other one.

## Running a dev instance

1. Ensure you have the necessary composer packages installed by doing `composer install` from the root directory.
3. Start the dev server by doing `php -S localhost:8000` from within the `src` directory.

### Changing the environment variables

1. Make a copy of the `.env` file and rename it to `.env.local`
2. Open the `.env.local` and edit it to apply your changes. This file will be ignored by the version control and can be used to overwrite the default options.

## Adding or updating an extension

### Considerations before adding an extension

- Your module's readme is expected to be written with markdown and any HTML in your module's readme will be automatically stripped as a safety precaution.

### Adding

TODO, but for now you can find it under `src/Library/Extensions` and add one.

### Updating

TODO, but for now you can find it under `src/Library/Extensions` and update it.

## Adding or updating an author

### Adding

1. Install the composer dependencies from within the root directory by performing `composer install`
2. Move to the `src` directory.
3. Use `php console.php add-author` and then follow the on-screen steps to add a new author.

### Updating

TODO, but for now you can find it under `src/Library/Authors` and update it.

## License
Each module is licensed under the terms set by the author. Please see the `LICENSE` file in each module for more information.
The extension directory website is licensed under the Apache 2.0 license. See the `LICENSE` file for more information.
