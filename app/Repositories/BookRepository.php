<?php
 namespace App\Repositories;

 use App\Book;

 class BookRepository implements BookInterface{
    public function all(){
        return Book::get();
    }

    public function get($id){
        return Book::find($id);
    }

    public function store(array $data){
        return Book::create($data);
    }

    public function update($id, array $data){
        return Book::find($id)->update($data);
    }

    public function delete($id){
        return Book::destroy($id);
    }
 }
