<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('No posts found');
    }

    public function testSee1BlogPostWhenThereIs1()
    {
        //Arrange
        $post = $this->createDummyBlogPost();

        //Act
        $response = $this->get('/posts');

        //Assert
        $response->assertSeeText('New Title');

        // $response->assert('blog_posts', [
        //     'title'=> 'New Title'
        // ]);


    }

    public function testStoreValid()
    {

        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];

        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog Post was created');
    }

    public function testStoreFail()
    {
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        $user=$this->user();

        $this->actingAs($user)
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    }

    public function testUpdateValid()
    {
        $user=$this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', $post->toArray());

        // dd($post);

        $params = [
            'title' => 'A new named title',
            'content' => 'Content was changed'
        ];

        $this->actingAs($user)
        ->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was updated!');

        $this->assertDatabaseMissing('blog_posts', $post->toArray());
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'A new named title',
        ]);
    }

    public function testSee1BlogPostWithComments()
    {
        $user=$this->user();
        $post = $this->createDummyBlogPost();

        // \App\Models\Comment::factory(Comment::class, 4)->create([
        //     'blog_post_id'=>$post->id
        // ]);

        Comment::factory(4)->create([
            'commentable_id' => $post->id,
            'commentable_type' => 'App\BlogPost',
            'user_id' => $user->id
        ]);

        $response = $this->get('/posts');

        $response->assertSeeText('4 comments');
    }

    public function testDelete()
    {
        $user=$this->user();

        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', $post->toArray());

        $this->actingAs($user)
        ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was deleted!');
        $this->assertDatabaseMissing('blog_posts', $post->toArray());
        $this->assertSoftDeleted('blog_posts', $post->toArray());
    }

    private function createDummyBlogPost($userId=null): BlogPost
    {

        // $post->title = 'New Title';
        // $post->content = 'Content of the blog post';
        // $post->save();

        // return $post;
        return BlogPost::factory()->newTitle()->create(
            [
                'user_id'=> $userId ?? $this->user()->id,
            ]
        );
    }
}
