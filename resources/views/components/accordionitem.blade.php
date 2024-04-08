<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapse-{{ $uniqueId }}" aria-expanded="true"
            aria-controls="collapse-{{ $uniqueId }}">
            {{ $title }}
        </button>
    </h2>
    <div id="collapse-{{ $uniqueId }}" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            {{ $slot }}
        </div>
    </div>
</div>
