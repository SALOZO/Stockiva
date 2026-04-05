@if($path)
<div class="d-flex justify-content-center gap-1">
    <a href="{{ Storage::url($path) }}"
       target="_blank"
       class="btn btn-sm btn-outline-info"
       title="Preview">
        <i class="bi bi-eye"></i>
    </a>
    <a href="{{ Storage::url($path) }}"
       download
       class="btn btn-sm btn-outline-primary"
       title="Download">
        <i class="bi bi-download"></i>
    </a>
</div>
@else
    <span class="text-muted small">-</span>
@endif
