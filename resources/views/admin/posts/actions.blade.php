<div class="table-actions d-flex align-items-center">
    <a href="{{route("admin.posts.edit", $post)}}" class="btn btn-primary btn-sm mr-1">Edit</a>
    <a href="{{route("posts.show", $post)}}" target="_blank" class="btn btn-default btn-sm mr-1">View</a>
    <button data-link="{{route("admin.posts.destroy", $post)}}" type="button" class="delete-resource btn btn-danger btn-sm">Delete</button>
</div>
