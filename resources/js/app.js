import './bootstrap';
import Alpine from 'alpinejs';
import angular from 'angular';

window.Alpine = Alpine;

Alpine.start();

angular.module('socialApp', [])
.controller('PostController', function($scope, $http) {
    $scope.posts = [];
    $scope.newPost = {
        content: '',
        visibility: 'Public' // Pre-select 'Public'
    };

    $scope.getPosts = function() {
        $http.get('/posts')
            .then(function(response) {
                $scope.posts = response.data;
            }, function(error) {
                console.error('Error fetching posts:', error);
                alert('Error fetching posts');
            });
    };

    $scope.createPost = function() {
        $http.post('/posts', $scope.newPost)
            .then(function(response) {
                $scope.posts.unshift(response.data);
                $scope.newPost = {}; // Clear form
            }, function(error) {
                console.error('Error creating post:', error);
                alert('Error creating post');
            });
    };

    $scope.enableEditPost = function(post) {
        post.isEditing = true; // Set the editing mode
        post.originalContent = post.content; // Store original content for cancellation
    };
    $scope.enableEditPost = function(post) {
        post.isEditing = true; // Set the editing mode
        post.originalContent = post.content; // Store original content for cancellation
    };
    
    $scope.editPost = function(post) {
        $http.patch('/posts/' + post.id, { content: post.content })
            .then(function(response) {
                post.isEditing = false; // Exit editing mode
            }, function(error) {
                console.error('Error editing post:', error);
                alert('Error editing post');
            });
    };
    
    $scope.cancelEditPost = function(post) {
        post.content = post.originalContent; // Reset to original content
        post.isEditing = false; // Exit editing mode
    };
    

    $scope.cancelEditPost = function(post) {
        post.content = post.originalContent; // Reset to original content
        post.isEditing = false; // Exit editing mode
    };

    $scope.enableEditComment = function(comment) {
        comment.isEditing = true; // Set the editing mode
        comment.originalComment = comment.comment; // Store original comment for cancellation
    };

    $scope.editComment = function(post, comment) {
        $http.patch('/posts/' + post.id + '/comments/' + comment.id, { comment: comment.comment })
            .then(function(response) {
                comment.isEditing = false; // Exit editing mode
            }, function(error) {
                console.error('Error editing comment:', error);
                alert('Error editing comment');
            });
    };

    $scope.cancelEditComment = function(comment) {
        comment.comment = comment.originalComment; // Reset to original comment
        comment.isEditing = false; // Exit editing mode
    };

    $scope.deleteComment = function(post, comment) {
        if (confirm('Are you sure you want to delete this comment?')) {
            $http.delete('/posts/' + post.id + '/comments/' + comment.id)
                .then(function(response) {
                    // Remove the comment from the post's comments array
                    var index = post.comments.indexOf(comment);
                    if (index > -1) {
                        post.comments.splice(index, 1);
                    }
                    alert(response.data.message);
                }, function(error) {
                    console.error('Error deleting comment:', error);
                    alert('Error deleting comment');
                });
        }
    };

    $scope.likePost = function(post) {
        $http.post('/posts/' + post.id + '/like')
            .then(function(response) {
                // Toggle like/unlike logic based on the response
                if (response.data.message === 'Post liked') {
                    post.likes_count++;
                    post.userHasLiked = true; // Keep track that the user has liked the post
                } else if (response.data.message === 'Post unliked') {
                    post.likes_count--;
                    post.userHasLiked = false; // Keep track that the user has unliked the post
                }
            }, function(error) {
                console.error('Error toggling like:', error);
                alert('Error toggling like');
            });
    };
    
    $scope.addComment = function(post) {
        $http.post('/posts/' + post.id + '/comment', { comment: post.newComment })
            .then(function(response) {
                post.comments.push(response.data); // Add the new comment to the post's comments array
                post.newComment = ''; // Clear the input field after successful comment submission
            }, function(error) {
                console.error('Error adding comment:', error);
                alert('Error adding comment');
            });
    };

    $scope.deletePost = function(post) {
        if (confirm('Are you sure you want to delete this post?')) {
            $http.delete('/posts/' + post.id)
                .then(function(response) {
                    // Remove the post from the list after deletion
                    var index = $scope.posts.indexOf(post);
                    if (index > -1) {
                        $scope.posts.splice(index, 1);
                    }
                    alert(response.data.message);
                }, function(error) {
                    console.error('Error deleting post:', error);
                    alert('Error deleting post');
                });
        }
    };

    $scope.getPosts();  // Fetch posts when the controller initializes
})
.controller('FriendController', function($scope, $http) {
    // FriendController code remains unchanged
});

// CSRF Token configuration
angular.module('socialApp').config(function($httpProvider) {
    $httpProvider.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
});
