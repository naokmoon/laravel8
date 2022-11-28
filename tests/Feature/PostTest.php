<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Comment;
use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('No blog posts yet!');
    }

    public function testSee1BlogPostWhenThereIs1()
    {
        // Arrange
        $post = $this->createDummyBlogPost();

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSeeText('New title');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New title'
        ]);
    }

    public function testSee1BlogPostWithComments()
    {
        // Arrange
        $user = $this->user();

        $post = $this->createDummyBlogPost();
        Comment::factory(4)->create([
            'commentable_id' => $post->id,
            'commentable_type' => BlogPost::class,
            'user_id' => $user->id
        ]);

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New title'
        ]);

        $post = BlogPost::find($post->id); // Get post from DB with comments

        $this->assertEquals(count($post->comments), 4); // Assert there are 4 comments found
    }

    public function testStoreValid()
    {
        $params = [
            'title' => 'Valid title',
            'content' => 'Atleast 10 characters'
        ];
        // Insert new blog post
        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');
        // Assert it has been inserted
        $this->assertEquals(session('status'), 'The blog post was created!');
    }

    public function testStoreFail()
    {
        // Send bad blog post to be rejected from validation
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];
        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');
        // Assert we receive error messages
        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['title'][0], "The title must be at least 5 characters.");
        $this->assertEquals($messages['content'][0], "The content must be at least 10 characters.");
    }

    public function testUpdateValid()
    {
        // Arrange
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New title',
            'content' => 'Content of the blog post'
        ]);

        // $params = [
        //     'title' => 'A new named title',
        //     'content' => 'Content was changed'
        // ];
        // $this->put("/posts/{$post->id}", $params)

        // Update blog post
        $post->title = "A new named title";
        $post->content = "Content was changed";

        $this->actingAs($user)
            ->put("/posts/{$post->id}", $post->toArray())
            ->assertStatus(302)
            ->assertSessionHas('status');
        // Assert it has been updated
        $this->assertEquals(session('status'), 'The blog post was updated!');
        $this->assertDatabaseMissing('blog_posts', ['title' => 'New title']);
        $this->assertDatabaseHas('blog_posts', ['title' => 'A new named title']);
    }

    public function testDeletePost()
    {
        $user =$this->user();
        $post = $this->createDummyBlogPost($user->id);

        // Delete blog post
        $this->actingAs($user)
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');
        // Assert it is deleted
        $this->assertEquals(session('status'), "The blog post #$post->id was deleted!");
        $this->assertDatabaseMissing('blog_posts', $post->toArray());

        return $post;
    }

    private function createDummyBlogPost($userId=null): BlogPost
    {
        // $post = new BlogPost();
        // $post->title = "New title";
        // $post->content = "Content of the blog post";
        // $post->save();

        // return $post;
        return BlogPost::factory()->dummyTest()->create(
            [
                'user_id' => $userId ?? $this->user()->id,
            ]
        );
    }
}
