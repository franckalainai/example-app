<?php

namespace App\Http\Controllers;

use App\Book;
use App\Repositories\BookRepository;
use Illuminate\Http\Request;
use DataTables;

class BooksController extends Controller
{
    protected $book;

    public function __construct(BookRepository $book)
    {
        $this->book = $book;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $books = $this->book->all();

        if ($request->ajax()) {
            $data = Book::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editBook">Edit</a>';

                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook">Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('book',compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*Book::updateOrCreate(['id' => $request->book_id],
                ['title' => $request->title, 'author' => $request->author]);
                */
        $this->book->store($request->all());

        return response()->json(['success'=>'Book saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$book = Book::find($id);
        $book = $this->book->get($id);
        return response()->json($book);
    }

    public function update($id, Request $request){
        $book = $this->book->update($id, $request->all());

        return response()->json($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Book::find($id)->delete();
        $this->book->delete($id);

        return response()->json(['success'=>'Book deleted successfully.']);
    }
}
