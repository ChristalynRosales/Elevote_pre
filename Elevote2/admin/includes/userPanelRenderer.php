<?php

class UserPanelRenderer {
    private $user;

    public function __construct($user) {
        $this->user = $user;
    }

    public function render() {
        $imageSrc = (!empty($this->user['photo'])) ? '../images/' . $this->user['photo'] : '../images/profile.jpg';

        echo '<div class="user-panel">';
        echo '<div class="pull-left image">';
        echo '<img src="' . $imageSrc . '" class="img-circle" alt="User Image">';
        echo '</div>';
        echo '<div class="pull-left info">';
        echo '<p>' . $this->user['firstname'] . ' ' . $this->user['lastname'] . '</p>';
        echo '<a><i class="fa fa-circle text-success"></i> Online</a>';
        echo '</div>';
        echo '</div>';
    }
}
?>
