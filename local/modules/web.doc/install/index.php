<?php

use Bitrix\Main\ModuleManager;

class web_doc extends CModule
{
    public function __construct()
    {
        $this->MODULE_VERSION = '1.0.0';
        $this->MODULE_VERSION_DATE = '16.09.2024';
        $this->MODULE_ID = 'web.doc'; // название модуля
        $this->MODULE_NAME = 'Документация'; // описание модуля
        $this->MODULE_DESCRIPTION = 'Документация к сайту';
        $this->MODULE_GROUP_RIGHTS = 'N';  // используем ли индивидуальную схему распределения прав доступа, мы ставим N, так как не используем ее
        $this->PARTNER_NAME = "WebCompany"; // название компании партнера предоставляющей модуль
        $this->PARTNER_URI = 'https://webcompany.by/uslugi/razrabotka-sajtov'; // адрес вашего сайта
    }

    private function copyAdminPages() : void
    {
        $adminFolderPath = __DIR__.'/../admin';
        if (is_dir($adminFolderPath)) {
            $filesList = scandir($adminFolderPath);
            if (!empty($filesList) && count($filesList) > 2) {
                foreach ($filesList as $file) {
                    if ($file !== '.' && $file !== '..' && $file !== 'menu.php'
                        && !file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$file)) {

                        copy(
                            $adminFolderPath.'/'.$file,
                            $_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$file
                        );
                    }
                }
            }
        }
    }

    private function copyAssets() : void
    {
        $sourceDir = __DIR__ . '/assets';
        if (is_dir($sourceDir)) {
            $folders = scandir($sourceDir);
            foreach ($folders as $folder) {
                if ($folder !== '.' && $folder !== '..' && is_dir($sourceDir . '/' . $folder)) {
                    $destinationDir = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/' . $folder . '/' . $this->MODULE_ID;
                    if (!is_dir($destinationDir)) {
                        mkdir($destinationDir, 0755, true);
                    }
                    $this->copyDirectoryRecursively($sourceDir . '/' . $folder, $destinationDir);
                }
            }
        }
    }

    private function copyDirectoryRecursively($sourceDir, $destinationDir) : void
    {
        $items = scandir($sourceDir);

        foreach ($items as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            $sourcePath = $sourceDir . '/' . $item;
            $destinationPath = $destinationDir . '/' . $item;

            if (is_dir($sourcePath)) {
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $this->copyDirectoryRecursively($sourcePath, $destinationPath);
            } else {
                if (!file_exists($destinationPath)) {
                    copy($sourcePath, $destinationPath);
                }
            }
        }
    }

    private function deleteAdminPages() : void
    {
        $adminFolderPath = __DIR__.'/../admin';
        if (is_dir($adminFolderPath)) {
            $filesList = scandir($adminFolderPath);
            if (!empty($filesList) && count($filesList) > 2) {
                foreach ($filesList as $file) {
                    if ($file !== '.' && $file !== '..' && $file !== 'menu.php'
                        && file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$file)) {

                        unlink($_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$file);
                    }
                }
            }
        }
    }
    private function deleteAssets() : void
    {
        $sourceDir = __DIR__ . '/assets';
        if (is_dir($sourceDir)) {
            $folders = scandir($sourceDir);
            foreach ($folders as $folder) {
                if ($folder !== '.' && $folder !== '..' && is_dir($sourceDir . '/' . $folder)) {
                    $moduleDir = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/' . $folder . '/' . $this->MODULE_ID;
                    if (is_dir($moduleDir)) {
                        $this->deleteDirectoryRecursively($moduleDir);
                    }
                }
            }
        }
    }

    private function deleteDirectoryRecursively($dir) : void
    {
        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            $path = $dir . '/' . $item;

            if (is_dir($path)) {
                $this->deleteDirectoryRecursively($path);
            } else {
                unlink($path);
            }
        }
        rmdir($dir);
    }

    public function doInstall()
    {
        $this->copyAssets();
        $this->copyAdminPages();
        ModuleManager::registerModule($this->MODULE_ID);
    }
    //вызываем метод удаления таблицы и удаляем модуль из регистра
    public function doUninstall()
    {
        $this->deleteAssets();
        $this->deleteAdminPages();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }
}
