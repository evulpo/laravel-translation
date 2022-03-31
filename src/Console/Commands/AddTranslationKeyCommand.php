<?php

namespace JoeDixon\Translation\Console\Commands;

class AddTranslationKeyCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translation:add-translation-key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new language key for the application';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $language = $this->ask(__('Enter the language for the key (e.g. en)'));

        // we know this should be single or group so we can use the `anticipate`
        // method to give our users a helping hand
        $type = $this->anticipate(__('Is this a json or array key?'), ['single', 'group']);

        // if the group type is selected, prompt for the group key
        if ($type === 'group') {
            $file = $this->ask(__('What is the group for this translation?'));
        }
        $key = $this->ask(__('What is the key for this translation?'));
        $value = $this->ask(__('What is the value for this translation?'));

        // attempt to add the key for single or group and fail gracefully if
        // exception is thrown
        if ($type === 'single') {
            try {
                $this->translation->addSingleTranslation($language, 'single', $key, $value);

                return $this->info(__('New language key added successfully 👏'));
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
        } elseif ($type === 'group') {
            try {
                $file = str_replace('.php', '', $file);
                $this->translation->addGroupTranslation($language, $file, $key, $value);

                return $this->info(__('New language key added successfully 👏'));
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
        } else {
            return $this->error(__('Translation type must be json or array'));
        }
    }
}
