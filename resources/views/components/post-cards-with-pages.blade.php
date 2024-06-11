<x-post-cards :posts="$posts" />

{!!$posts->onEachSide(2)->links('vendor.pagination.default')!!}
