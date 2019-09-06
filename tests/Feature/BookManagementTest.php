<?php

namespace Tests\Feature;
use App\Book;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books',[
            'title' => 'Cool book title',
            'author' => 'Victor'
        ]);

        $this->assertCount(1, Book::all());

        $book = Book::first();
        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_title_is_required()
    {
        $response = $this->post('/books',[
            'title' => '',
            'author' => 'Victor'
        ]);

        $response->assertSessionHasErrors('title');        
    }

    /** @test */
    public function an_author_is_required()
    {
        $response = $this->post('/books',[
            'title' => 'Cool title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');        
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books',[
            'title' => 'Cool book title',
            'author' => 'Victor'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New title',
            'author' => 'New author'
        ]);

        $this->assertEquals("New title", Book::first()->title);
        $this->assertEquals("New author", Book::first()->author); 
        ///Repeat each field!!!!

        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->post('/books',[
            'title' => 'Cool book title',
            'author' => 'Victor'
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }

}
