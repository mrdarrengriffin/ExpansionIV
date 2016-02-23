<?php
use MrDarrenGriffin\Blog\Blog;
$app->get('/blog',function() use ($app){
  $posts = Blog::with('user')->where('enabled',1)->get();
  $app->render('blog/blog.php',['blogItems' => $posts]);
})->name('blog.home');

$app->post('/blog/create-post',function() use ($app){
  if(!$app->auth OR !$app->auth->hasPermission("blog.create-posts")){$app->notFound();}
  $request = $app->request;
  $v = $app->validation;
  $v->validate([
    'blog-title' => [$request->post('blog-title'),'required|max(255)'],
    'blog-content' => [$request->post('blog-content'),'required'],
    'blog-reddit-link' => [$request->post('blog-reddit-link'),'max(255)'],
  ]);
  if($v->passes()){
    $post = new Blog();
    $post->title = $request->post('blog-title');
    $post->content = $request->post('blog-content');
    $post->redditLink = $request->post('blog-reddit-link');
    $post->enabled = 1;
    $post->user_id = $app->auth->id;
    $post->timestamp_created = time();
    $post->save();
    $app->flash('success','Post created successfully');
    $app->response->redirect($app->urlFor('blog.home'));
  }else{
    $posts = Blog::with('user')->where('enabled',1)->get();
    $app->render('blog/blog.php',[
      'errors' => $v->errors(),
      'blogItems' => $posts,
      'request' => $request
    ]);
  }
})->name('blog.create-post.post');
