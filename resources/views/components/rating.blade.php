<div class="d-flex">
    <span class="material-icons {{ $review->rating >= 1 ? 'text-warning' : 'text-muted'}} h6">star</span>
    <span class="material-icons {{ $review->rating >= 2 ? 'text-warning' : 'text-muted'}} h6">star</span>
    <span class="material-icons {{ $review->rating >= 3 ? 'text-warning' : 'text-muted'}} h6">star</span>
    <span class="material-icons {{ $review->rating >= 4 ? 'text-warning' : 'text-muted'}} h6">star</span>
    <span class="material-icons {{ $review->rating >= 5 ? 'text-warning' : 'text-muted'}} h6">star</span>
</div>