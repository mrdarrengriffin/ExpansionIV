{% extends 'templates/default.php' %}

{% block title %}Blog{% endblock %}

{% block content %}
<div class="blog-container">
  {% if auth.hasPermission('blog.create-posts') %}
  <form action="{{ urlFor('blog.create-post.post') }}" method="post" autocomplete="off">
    <div class="panel panel-default">
      <div class="panel-heading">Create Blog Post</div>
      <div class="panel-body">
        <div class="form-group">
          <label for="blog-title">Post Title <span class="required">*</span></label>
          <input type="text" class="form-control char-count" data-limit='255' name="blog-title" id="blog-title" required value="{{ request.post('blog-title') }}">
          <span class="help-block">{% if errors.first('blog-title') %}{{ errors.first('blog-title') }}{% endif %}</span>
        </div>
        <div class="form-group">
          <label for="blog-ckeditor">Content <span class="required">*</span></label>
          <textarea name="blog-content" id="ckeditor" required></textarea>
          <span class="help-block">{% if errors.first('blog-content') %}{{ errors.first('blog-content') }}{% endif %}</span>
        </div>
        {% if config.get('social.reddit.enabled') %}
        <div class="form-group">
          <label for="blog-reddit-link">Reddit Discussion URL</label>
          <input type="text" class="form-control char-count" data-limit='255' name="blog-reddit-link" id="blog-reddit-link" placeholder="e.g. https://redd.it/3i2ffz">
        </div>
        <span class="help-block">{% if errors.first('blog-reddit-link') %}{{ errors.first('blog-reddit-link') }}{% endif %}</span>
        {% endif %}
      </div>

      <div class="panel-footer">
        <i>All fields marked with <span class="required">*</span> are required.</i>
        <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
        <div class="text-right" style="float:right;">
          <input type="submit" class="btn btn-sm btn-success" value="Create Post">
        </div>
      </div>

    </div>

  </form>
  <hr>
  {% endif %}

  {% if blogItems.count == 0 %}
  <h1 class="text-center">No blog posts yet!</h1>
  <h4 class="text-center text-muted">We shall post some soon though! Hold Tight!</h4>
  {% endif %}

  {% for b in blogItems %}
  <div class="blog-item">
    <div class="blog-heading">
      <span class="blog-title">{{ b.title }}</span>
      <span class="blog-subtitle">posted by <strong>{{ b.user.username }}</strong> on <strong>{{ b.timestamp_created | date("F jS, Y") }}</strong> at <strong>{{ b.timestamp_created | date("H:ia") }}</strong></span>
    </div>
    <div class="blog-content">{{ b.content | raw }}</div>
    <div class="blog-item-footer">

      {% if config.get('social.reddit.enabled') and b.redditLink %}
      <span class="blog-discuss-reddit"><a href="{{ b.redditLink }}">Discuss this post on Reddit</a></span>
      {% endif %}
    </div>
  </div>
  {% endfor %}
</div>
{% endblock %}
