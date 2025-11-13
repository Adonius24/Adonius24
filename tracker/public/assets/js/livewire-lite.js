(function () {
    const components = document.querySelectorAll('[data-livewire-component]');
    components.forEach((component) => {
        component.__livewire = {
            emit(event, detail) {
                component.dispatchEvent(new CustomEvent(event, { detail }));
            }
        };
    });
})();
