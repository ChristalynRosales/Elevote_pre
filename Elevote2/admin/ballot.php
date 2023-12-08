<?php

include 'includes/session.php';

class Ballot
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function displayHeader()
    {
        echo '<!DOCTYPE html>';
        echo '<html lang="en">';
        echo '<head>';
        echo '    <!-- Include your head content here -->';
        echo '</head>';
    }

    public function displayBodyHeader()
    {
        echo '<body class="hold-transition skin-blue sidebar-mini">';
        echo '    <div class="wrapper">';
        include 'includes/navbar.php';
        include 'includes/menubar.php';
    }

    public function displayContentHeader()
    {
        echo '        <!-- Content Wrapper. Contains page content -->';
        echo '        <div class="content-wrapper">';
        echo '            <!-- Content Header (Page header) -->';
        echo '            <section class="content-header">';
        echo '                <h1>Ballot Position</h1>';
        echo '                <ol class="breadcrumb">';
        echo '                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>';
        echo '                    <li class="active">Ballot Preview</li>';
        echo '                </ol>';
        echo '            </section>';
        echo '            <!-- Main content -->';
        echo '            <section class="content">';
        if (isset($_SESSION['error'])) {
            echo $this->getAlert('danger', $_SESSION['error']);
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo $this->getAlert('success', $_SESSION['success']);
            unset($_SESSION['success']);
        }
    }

    public function displayContent()
    {
        echo '<div class="alert-container"></div>';
        echo '<div class="row">';
        echo '  <div class="col-xs-10 col-xs-offset-1" id="content"></div>';
        echo '</div>';
    }

    public function displayContentFooter()
    {
        echo '            </section>';
        echo '        </div>';
    }

    public function displayBodyFooter()
    {
        include 'includes/footer.php';
        echo '    </div>';
    }

    public function displayFooter()
    {
        echo '</body>';
        echo '</html>';
    }

    public function displayScripts()
    {
        echo '<script>';
        echo '$(function(){';
        // ... (existing script code)
        echo '});';

        echo 'function fetch(){';
        // ... (existing fetch function code)
        echo '}';
        echo '</script>';
    }

    private function getAlert($type, $message)
    {
        return "
            <div class='alert alert-$type alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4><i class='icon fa fa-" . ($type === 'success' ? 'check' : 'warning') . "'></i> " . ucfirst($type) . "!</h4>
                $message
            </div>
        ";
    }
}

$ballot = new Ballot($conn);
$ballot->displayHeader();
$ballot->displayBodyHeader();
$ballot->displayContentHeader();
$ballot->displayContent();
$ballot->displayContentFooter();
$ballot->displayBodyFooter();
$ballot->displayFooter();
$ballot->displayScripts();
?>
