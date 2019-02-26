<?php

namespace CKEditorBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class CKEditorBundle extends AbstractPimcoreBundle
{
    public function getVersion()
    {
        return '1.0.0';
    }

    public function getDescription()
    {
        return 'Custom configuration for CKEditore';
    }

    // public function getEditmodeJsPaths()
    // {
    //     return [
    //         '/bundles/ckeditor/js/ck-editmode.js'
    //     ];
    // }

    public function getJsPaths()
    {

        return [
            '/bundles/ckeditor/js/ckeditor.js'
        ];
    }
}
