<?php

function a() {
    echo "Uncovered";
}

function b() {
    echo "Covered";
    var_dump($_SERVER['argv']);
}

b();