  <div class="grid-prod">

                                                                <div class="prod-grid">
                                                                    <div class="image-container"><a href="{{ route('countries.info', $country->translation('slug')) }}">
                                                                        <img
                                                                            @isset($country->info['0']['preview_image'])src="{{ asset('storage/' . $country->info['0']['preview_image']) }}"
                                                                            @endisset
                                                                            alt="preview_image"></a>
                                                                    </div>

                                                                    <h1 class="wiki__min-title link">
                                                                        <a href="{{ route('countries.info', $country->translation('slug')) }}">Полезная информация об Узбекистане для туристов</a>
                                                                    </h1>

                                                                </div>

                                                                <div class="prod-grid">
                                                                    <div class="image-container">
                                                                        <a href="{{ route('countries.cities', $country->translation('slug')) }}"><img
                                                                            @isset($country->cities->first()->preview_image)src="{{ asset('storage/' . $country->cities->first()->preview_image) }}"
                                                                            @endisset
                                                                            alt="preview_image"></a>
                                                                    </div>

                                                                    <h1 class="wiki__min-title link">
                                                                        <a href="{{ route('countries.cities', $country->translation('slug')) }}">Туристические города Узбекистана</a>
                                                                    </h1>

                                                                </div>

                                                                <div class="prod-grid">
                                                                    <div class="image-container">
                                                                        <a href="{{ route('countries.sights', $country->translation('slug')) }}"><img
                                                                            src="{{ asset('storage/' . $sight_image) }}"
                                                                            alt="preview_image"></a>
                                                                    </div>

                                                                    <h1 class="wiki__min-title link">
                                                                        <a href="{{ route('countries.sights', $country->translation('slug')) }}">Культурные памятники Узбекистана</a>
                                                                    </h1>

                                                                </div>

                                                                <div class="prod-grid">

                                                                    <div class="image-container"><a href="{{ route('countries.history', $country->translation('slug')) }}">
                                                                        <img
                                                                            src="{{ asset('storage/' . $history_image) }}"
                                                                            alt="preview_image"></a>
                                                                    </div>

                                                                    <h1 class="wiki__min-title link">
                                                                        <a href="{{ route('countries.history', $country->translation('slug')) }}">История Узбекистана</a>
                                                                    </h1>

                                                                </div>


                                                                <div class="prod-grid">
                                                                    <div class="image-container"><a href="{{ route('countries.cuisines', $country->translation('slug')) }}">
                                                                        <img
                                                                            src="{{ asset('storage/' . $country->preview_image) }}"
                                                                            alt="preview_image"></a></div>

                                                                    <h1 class="wiki__min-title link">
                                                                        <a href="{{ route('countries.cuisines', $country->translation('slug')) }}">Кухня Узбекистана</a>
                                                                    </h1>

                                                                </div>

                                                                <div class="prod-grid">
                                                                    <div class="image-container"><a href="{{ route('countries.souvenirs', $country->translation('slug')) }}">
                                                                        <img
                                                                            src="{{ asset('storage/' . $country->preview_image) }}"
                                                                            alt="preview_image"></a>
                                                                    </div>

                                                                    <h1 class="wiki__min-title link">
                                                                        <a href="{{ route('countries.souvenirs', $country->translation('slug')) }}">Узбекские Сувениры</a>
                                                                    </h1>

                                                                </div>


                                                            </div>