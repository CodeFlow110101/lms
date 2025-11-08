<div>
    Membership Status: <span class="@if($status) !text-success-500 @else !text-danger-500 @endif">{{ $status ? 'Active' : 'Inactive' }}</span>
</div>