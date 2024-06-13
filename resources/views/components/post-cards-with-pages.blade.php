<x-post-cards :posts="$posts" />

{!!$posts->links('vendor.pagination.category-posts', compact('category'))!!}
