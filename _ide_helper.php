<?php

/**
 * IDE Helper para Laravel
 * Este arquivo ajuda o Intelephense a reconhecer os métodos das facades do Laravel
 */

namespace Illuminate\Support\Facades {
    /**
     * @method static \Illuminate\Contracts\Filesystem\Filesystem disk(string $name = null)
     * @method static bool exists(string $path)
     * @method static string get(string $path)
     * @method static string|false put(string $path, string|resource $contents, mixed $options = [])
     * @method static string|false putFile(string $path, \Illuminate\Http\File|\Illuminate\Http\UploadedFile|string $file, mixed $options = [])
     * @method static string|false putFileAs(string $path, \Illuminate\Http\File|\Illuminate\Http\UploadedFile|string $file, string $name, mixed $options = [])
     * @method static bool delete(string|array $paths)
     * @method static bool copy(string $from, string $to)
     * @method static bool move(string $from, string $to)
     * @method static int size(string $path)
     * @method static int lastModified(string $path)
     * @method static array files(string $directory = null, bool $recursive = false)
     * @method static array allFiles(string $directory = null)
     * @method static array directories(string $directory = null, bool $recursive = false)
     * @method static array allDirectories(string $directory = null)
     * @method static bool makeDirectory(string $path)
     * @method static bool deleteDirectory(string $directory)
     * @method static \Symfony\Component\HttpFoundation\StreamedResponse download(string $path, string $name = null, array $headers = [])
     * @method static string path(string $path)
     * @method static string url(string $path)
     * @method static string temporaryUrl(string $path, \DateTimeInterface $expiration, array $options = [])
     * @method static array|null getMetadata(string $path)
     * @method static string|null mimeType(string $path)
     * @method static resource|null readStream(string $path)
     * @method static bool writeStream(string $path, resource $resource, array $options = [])
     * @method static string|false prepend(string $path, string $data)
     * @method static string|false append(string $path, string $data)
     */
    class Storage extends Facade {}
}

namespace Illuminate\Contracts\Filesystem {
    interface Filesystem {
        /**
         * Download a file.
         *
         * @param  string  $path
         * @param  string|null  $name
         * @param  array  $headers
         * @return \Symfony\Component\HttpFoundation\StreamedResponse
         */
        public function download($path, $name = null, array $headers = []);
        
        /**
         * Get the full path to the file.
         *
         * @param  string  $path
         * @return string
         */
        public function path($path);
        
        /**
         * Get the URL for the file at the given path.
         *
         * @param  string  $path
         * @return string
         */
        public function url($path);
        
        /**
         * Get a temporary URL for the file at the given path.
         *
         * @param  string  $path
         * @param  \DateTimeInterface  $expiration
         * @param  array  $options
         * @return string
         */
        public function temporaryUrl($path, $expiration, array $options = []);
        
        /**
         * Determine if a file exists.
         *
         * @param  string  $path
         * @return bool
         */
        public function exists($path);
        
        /**
         * Get the contents of a file.
         *
         * @param  string  $path
         * @return string
         */
        public function get($path);
        
        /**
         * Write the contents of a file.
         *
         * @param  string  $path
         * @param  string|resource  $contents
         * @param  mixed  $options
         * @return string|false
         */
        public function put($path, $contents, $options = []);
        
        /**
         * Store the uploaded file on the disk.
         *
         * @param  string  $path
         * @param  \Illuminate\Http\File|\Illuminate\Http\UploadedFile|string  $file
         * @param  mixed  $options
         * @return string|false
         */
        public function putFile($path, $file, $options = []);
        
        /**
         * Store the uploaded file on the disk with a given name.
         *
         * @param  string  $path
         * @param  \Illuminate\Http\File|\Illuminate\Http\UploadedFile|string  $file
         * @param  string  $name
         * @param  mixed  $options
         * @return string|false
         */
        public function putFileAs($path, $file, $name, $options = []);
        
        /**
         * Prepend to a file.
         *
         * @param  string  $path
         * @param  string  $data
         * @return string|false
         */
        public function prepend($path, $data);
        
        /**
         * Append to a file.
         *
         * @param  string  $path
         * @param  string  $data
         * @return string|false
         */
        public function append($path, $data);
        
        /**
         * Delete the file at a given path.
         *
         * @param  string|array  $paths
         * @return bool
         */
        public function delete($paths);
        
        /**
         * Copy a file to a new location.
         *
         * @param  string  $from
         * @param  string  $to
         * @return bool
         */
        public function copy($from, $to);
        
        /**
         * Move a file to a new location.
         *
         * @param  string  $from
         * @param  string  $to
         * @return bool
         */
        public function move($from, $to);
        
        /**
         * Get the size of the file at the given path.
         *
         * @param  string  $path
         * @return int
         */
        public function size($path);
        
        /**
         * Get the file's last modification time.
         *
         * @param  string  $path
         * @return int
         */
        public function lastModified($path);
        
        /**
         * Get an array of all files in a directory.
         *
         * @param  string|null  $directory
         * @param  bool  $recursive
         * @return array
         */
        public function files($directory = null, $recursive = false);
        
        /**
         * Get all of the files from the given directory (recursive).
         *
         * @param  string|null  $directory
         * @return array
         */
        public function allFiles($directory = null);
        
        /**
         * Get all of the directories within a given directory.
         *
         * @param  string|null  $directory
         * @param  bool  $recursive
         * @return array
         */
        public function directories($directory = null, $recursive = false);
        
        /**
         * Get all (recursive) of the directories within a given directory.
         *
         * @param  string|null  $directory
         * @return array
         */
        public function allDirectories($directory = null);
        
        /**
         * Create a directory.
         *
         * @param  string  $path
         * @return bool
         */
        public function makeDirectory($path);
        
        /**
         * Recursively delete a directory.
         *
         * @param  string  $directory
         * @return bool
         */
        public function deleteDirectory($directory);
        
        /**
         * Get the metadata for a file.
         *
         * @param  string  $path
         * @return array|null
         */
        public function getMetadata($path);
        
        /**
         * Get the MIME type of a given file.
         *
         * @param  string  $path
         * @return string|null
         */
        public function mimeType($path);
        
        /**
         * Get a resource to read the file.
         *
         * @param  string  $path
         * @return resource|null
         */
        public function readStream($path);
        
        /**
         * Write a new file using a stream.
         *
         * @param  string  $path
         * @param  resource  $resource
         * @param  array  $options
         * @return bool
         */
        public function writeStream($path, $resource, array $options = []);
    }
}