@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.car.actions.edit', ['name' => $car->id]))

@section('body')

    {{-- Підключення Google Maps JavaScript API тут. --}}
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('Maps_API_KEY') }}&libraries=places&callback=initMap" async defer></script>

    <div class="container-xl">
        <div class="card">

            <car-form
                :action="'{{ $car->resource_url }}'"
                :data="{{ $car->toJson() }}"
                :car_models="{{$car_models->toJson()}}"
                :cities="{{$cities->toJson()}}"
                :cars_colors="{{$cars_colors->toJson()}}"
                :fuels="{{$fuels->toJson()}}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.car.actions.edit', ['name' => $car->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.car.components.form-elements')
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                </form>

            </car-form>

        </div>
    </div>

    {{-- Скрипт для ініціалізації карти та логіки взаємодії. --}}
    <script>
        let map;
        let marker;
        let geocoder;
        let autocomplete;

        // Додаємо глобальну змінну для доступу до Vue-компонента
        // ЦЕ ДУЖЕ ВАЖЛИВО, якщо ви хочете оновлювати Vue-модель безпосередньо.
        // Переконайтеся, що ваш Vue-компонент car-form доступний через window.App.Components.CarForm,
        // або знайдіть інший спосіб отримати доступ до його екземпляра.
        // Якщо ви використовуєте адмін-панель Brackets, можливо, у них є свій спосіб реєстрації компонентів.
        // Тимчасовий обхідний шлях, якщо ви не можете отримати доступ до екземпляра Vue-компонента:
        // Ми будемо покладатися на dispatchEvent, але спробуємо його покращити.
        // Якщо ви можете отримати доступ до екземпляра Vue-компонента, це найкращий шлях.

        // Функція для програмного оновлення інпуту та тригера події 'input' для Vue
        function updateInputAndTriggerVue(inputElement, value) {
            if (!inputElement) {
                console.warn('Attempted to update a non-existent input element.');
                return;
            }

            // Оновлюємо значення DOM-елемента
            inputElement.value = value;
            console.log(`Updated ${inputElement.id} to: ${value}`);

            // Створюємо нову подію 'input'
            const event = new Event('input', { bubbles: true });

            // Диспатчимо подію. Vue зазвичай слухає цю подію для v-model.
            inputElement.dispatchEvent(event);
            console.log(`Dispatched 'input' event for ${inputElement.id}`);

            // Додаткова перевірка для Vue:
            // Якщо ви використовуєте Vue Devtools, перевірте, чи оновився form.value
            // Якщо ні, можливо, Vue не реагує на цю подію або слухає іншу.
            // У деяких випадках Vue може використовувати внутрішні властивості для своїх слухачів.
            // Наприклад, inputElement._v_listeners.input
            // Якщо ви бачите, що Vue-модель не оновлюється, спробуйте вручну викликати
            // inputElement._v_listeners.input[0]() якщо такий шлях існує.
            // АБО НАЙКРАЩЕ: отримати доступ до екземпляра Vue-компонента і оновити this.form.latitude = value;
        }


        // Ця функція буде викликана Google Maps API після його завантаження
        function initMap() {
            const addressInput = document.getElementById('address-input');
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');
            const mapElement = document.getElementById('map');

            if (!addressInput || !latitudeInput || !longitudeInput || !mapElement) {
                console.warn('Map elements not found. Skipping Google Maps initialization.');
                return;
            }

            const initialLat = parseFloat(latitudeInput.value) || 49.0;
            const initialLng = parseFloat(longitudeInput.value) || 32.0;

            map = new google.maps.Map(mapElement, {
                center: { lat: initialLat, lng: initialLng },
                zoom: 6,
            });

            geocoder = new google.maps.Geocoder();

            marker = new google.maps.Marker({
                map: map,
                position: { lat: initialLat, lng: initialLng },
                draggable: true,
            });

            autocomplete = new google.maps.places.Autocomplete(addressInput);
            autocomplete.bindTo('bounds', map);

            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace();
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                updateInputAndTriggerVue(latitudeInput, place.geometry.location.lat());
                updateInputAndTriggerVue(longitudeInput, place.geometry.location.lng());
                updateInputAndTriggerVue(addressInput, place.formatted_address);

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                marker.setPosition(place.geometry.location);
            });

            marker.addListener('dragend', () => {
                const newPosition = marker.getPosition();
                updateInputAndTriggerVue(latitudeInput, newPosition.lat());
                updateInputAndTriggerVue(longitudeInput, newPosition.lng());
                map.setCenter(newPosition);

                geocoder.geocode({ 'location': newPosition }, (results, status) => {
                    if (status === 'OK' && results[0]) {
                        updateInputAndTriggerVue(addressInput, results[0].formatted_address);
                    } else {
                        console.error('Geocoder failed due to: ' + status);
                    }
                });
            });

            map.addListener("click", (event) => {
                updateInputAndTriggerVue(latitudeInput, event.latLng.lat());
                updateInputAndTriggerVue(longitudeInput, event.latLng.lng());

                marker.setPosition(event.latLng);
                map.setCenter(event.latLng);

                geocoder.geocode({ 'location': event.latLng }, (results, status) => {
                    if (status === 'OK' && results[0]) {
                        updateInputAndTriggerVue(addressInput, results[0].formatted_address);
                    } else {
                        console.error('Geocoder failed due to: ' + status);
                    }
                });
            });

            // Ініціалізація початкової адреси на карті, якщо дані вже є
            if (latitudeInput.value && longitudeInput.value) {
                const currentLat = parseFloat(latitudeInput.value);
                const currentLng = parseFloat(longitudeInput.value);
                const currentPosition = { lat: currentLat, lng: currentLng };

                map.setCenter(currentPosition);
                map.setZoom(17);
                marker.setPosition(currentPosition);

                if (!addressInput.value) {
                    geocoder.geocode({ 'location': currentPosition }, (results, status) => {
                        if (status === 'OK' && results[0]) {
                            updateInputAndTriggerVue(addressInput, results[0].formatted_address);
                        }
                    });
                }
            }
        }
    </script>
@endsection
