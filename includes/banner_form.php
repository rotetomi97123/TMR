 <div class="banner_wrapper">
        <div class="banner_content">
            <div class="banner_content_flex">
                <h2>Your dream home is just a click away!</h2>
                <p>A great platform to buy, sell, or even rent your properties without any commisions.</p>
                <form id="property-search-form" method="GET" action="./api/search.php">
                    <input type="text" id="location" name="city_area" placeholder="Location" />

                    <select id="property_type" name="property_type">
                        <option value="" selected>Any Type</option>
                        <option value="apartment">Apartment</option>
                        <option value="house">House</option>
                    </select>

                    <div class="form-row">
                        <input type="number" name="price_from" placeholder="Price from ($)" min="0" />
                        <input type="number" name="price_to" placeholder="Price to ($)" min="0" />
                    </div>

                    <button type="submit">Search</button>
                    </form>
            </div>
        </div>
</div>