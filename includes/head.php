<?php

function setVoterButton()
{
    if (!isset($_SESSION["voter"])) {
        return ' <button class="my-btn-primary" data-bs-toggle="modal" data-bs-target="#voterslogin">Login</button>';
    } else {
        return '<a href="/voters" class="my-btn-primary" name="voterLogin"> 
            My Account
        </a>';
    }
}