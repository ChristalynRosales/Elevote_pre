<?php

class ConfigManager
{
    private $configFile = 'config.ini';

    public function updateTitle($title)
    {
        $content = 'election_title = ' . $title;
        file_put_contents($this->configFile, $content);
    }
}

class ConfigController
{
    private $configManager;

    public function __construct(ConfigManager $configManager)
    {
        $this->configManager = $configManager;
    }

    public function handleRequest()
    {
        session_start();
        include 'includes/session.php';

        $return = 'home.php';
        if (isset($_GET['return'])) {
            $return = $_GET['return'];
        }

        if (isset($_POST['save'])) {
            $title = $_POST['title'];

            $this->configManager->updateTitle($title);

            $_SESSION['success'] = 'Election title updated successfully';
        } else {
            $_SESSION['error'] = 'Fill up config form first';
        }

        header('location: ' . $return);
    }
}

// Usage
$configManager = new ConfigManager();
$configController = new ConfigController($configManager);
$configController->handleRequest();
