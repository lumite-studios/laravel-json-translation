<?php

namespace LumiteStudios\JSONTranslations;

use RuntimeException;
use Illuminate\Translation\FileLoader;

class Loader extends FileLoader
{
    /**
     * Add a new JSON path to the loader.
     *
     * @param  string  $path
     * @return void
     */
    public function addJsonPath($data)
    {
        if (is_array($data)) {
            $this->jsonPaths[$data['prefix']] = $data['path'];
        } else {
            $this->jsonPaths[] = $data;
        }
    }

    /**
     * Load a locale from the given JSON file path.
     *
     * @param  string  $locale
     * @return array
     *
     * @throws \RuntimeException
     */
    protected function loadJsonPaths($locale)
    {
        return collect($this->jsonPaths)
            ->reduce(function ($output, $path, $prefix) use ($locale) {
                if ($this->files->exists($full = "{$path}/{$locale}.json")) {
                    $decoded = json_decode($this->files->get($full), true);

                    if (is_string($prefix)) {
                        $decoded = collect($decoded)->mapWithKeys(function ($value, $key) use ($prefix) {
                            return ["{$prefix}.{$key}" => $value];
                        })->toArray();
                    }

                    if (is_null($decoded) || json_last_error() !== JSON_ERROR_NONE) {
                        throw new RuntimeException("Translation file [{$full}] contains an invalid JSON structure.");
                    }

                    $output = array_merge($output, $decoded);
                }

                return $output;
            }, []);
    }
}
