<?php
require_once __DIR__ . "/../../Infrastructure/Repositories/AttractionRepositoryImpl.php";

class ManageAttraction {
    public function create($data) {
        $repo = new AttractionRepositoryImpl();
        return $repo->create($data);
    }

    public function getAll() {
        $repo = new AttractionRepositoryImpl();
        return $repo->getAll();
    }
}
