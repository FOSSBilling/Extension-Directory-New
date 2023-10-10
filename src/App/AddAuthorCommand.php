<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddAuthorCommand extends Command
{
    private string $templatePath = __DIR__ . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR . 'Author.template';
    private string $libraryPath = BASE_PATH . DIRECTORY_SEPARATOR . 'Library' . DIRECTORY_SEPARATOR . 'Authors';

    protected static $defaultName = 'add-author';

    protected function configure()
    {
        $this->setDescription('Adds a new author to the Extension Directory.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $io = new SymfonyStyle($input, $output);

        $io->title('Add a new author');

        // Ask for the type of author to add
        $io->section('Author type');
        $question = new ChoiceQuestion(
            'What type of author would you like to add? (individual)',
            ['individual', 'organization'],
            0
        );
        $type = $helper->ask($input, $output, $question);

        // Ask for the display name of the author to add
        $io->section('Author display name');
        $question = new Question('Please enter the display name of the author you are adding: ');
        $question->setValidator(function (?string $answer): string {
            if (empty($answer)) {
                throw new \RuntimeException('You must enter a name');
            }

            return $answer;
        });
        $displayName = $helper->ask($input, $output, $question);

        // Generate an ID for the author based on the display name
        $generatedID = preg_replace('/[^a-z0-9]/', '', strtolower($displayName));

        // Ask for an ID to use for the author
        $io->section('Author ID');
        $io->text('The ID can only contain lowercase letters and numbers.');
        $question = new Question("Please enter an ID you'd like to use for this author ($generatedID): ", $generatedID);
        $question->setValidator(function (?string $answer): string {
            if (class_exists('\\ExtensionDirectory\\Authors\\' . $answer)) {
                throw new \RuntimeException('This ID is already taken');
            }

            if (!ctype_alnum($answer) || ($answer !== strtolower($answer))) {
                throw new \RuntimeException('The ID must only contain lowercase letters and numbers');
            }

            return $answer;
        });
        $id = $helper->ask($input, $output, $question);

        // Ask for a webpage URL for the author
        $io->section('Author Webpage URL');
        $io->text('The webpage URL must start with a protocol (HTTPS).');
        $question = new Question("Please enter a webpage URL for this author: ");
        $question->setValidator(function (?string $answer): string {
            if (!filter_var($answer, FILTER_VALIDATE_URL)) {
                throw new \RuntimeException('The URL you\'ve entered appears to be invalid');
            }

            return $answer;
        });
        $url = $helper->ask($input, $output, $question);

        // Generate the author file from the template
        $template = file_get_contents($this->templatePath);
        $authorFileContent = strtr($template, [
            ':type:' => $type,
            ':name:' => $displayName,
            ':id:' => $id,
            ':url:' => $url,
        ]);

        // Write the author file to the library
        if (!file_put_contents($this->libraryPath . DIRECTORY_SEPARATOR . $id . '.php', $authorFileContent)) {
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
