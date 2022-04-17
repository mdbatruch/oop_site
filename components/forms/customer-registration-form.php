<form id="customer-register" method="post" class="flex-column justify-content-center customer-register">
    <div>
        <h3 class="mb-4 w-100"><img src="<?= root_url('uploads/register.png'); ?>" alt="Login" class="img-fluid me-3">Register</h3>
        <div class="form-container">
            <div id="form-message"></div>
            <div class="form-field">
                <label class="mb-1">First Name<span class="ast">*</span></label>
                <input type="text" id="firstname" name="firstname" placeholder="First Name"/>
                <div id="firstname-error"></div>
            </div>
            <br />
            <div class="form-field">
                <label class="mb-1">Last Name<span class="ast">*</span></label>
                <input type="text" id="lastname" name="lastname" placeholder="Last Name"/>
                <div id="lastname-error"></div>
            </div>
            <br />
            <div class="form-field">
                <label class="mb-1">Email<span class="ast">*</span></label>
                <input type="text" id="email" name="email" placeholder="Email"/>
                <div id="email-error"></div>
            </div>
            <br />
            <div class="form-field">
                <label class="mb-1">Address<span class="ast">*</span></label>
                <input type="text" id="street" class="mb-2" name="street_name_number" placeholder="Street Name and Number" />
                <div id="street-error" class="warning"></div>
                <input type="text" id="suite" class="mb-2" name="street_name_number" placeholder="Suite or Apartment Number (optional)" />
                <input type="text" id="city" class="mb-2" name="city" placeholder="City" />
                <div id="city-error" class="warning"></div>
                <div class="form-field-inner d-flex">
                    <div class="field-container d-flex flex-column">
                        <select name="province" id="province" class="province">
                            <option value="">Prov./Ter.</option>
                            <option value="AB" class="province-value">Alberta
                            </option><option value="BC" class="province-value">British Columbia
                            </option><option value="MB" class="province-value">Manitoba
                            </option><option value="NB" class="province-value">New Brunswick
                            </option><option value="NL" class="province-value">Newfoundland and Labrador
                            </option><option value="NT" class="province-value">Northwest Territories
                            </option><option value="NS" class="province-value">Nova Scotia
                            </option><option value="NU" class="province-value">Nunavut
                            </option><option value="ON" class="province-value">Ontario
                            </option><option value="PE" class="province-value">Prince Edward Island
                            </option><option value="QC" class="province-value">Quebec
                            </option><option value="SK" class="province-value">Saskatchewan
                            </option><option value="YT" class="province-value">Yukon Territory
                            </option>
                        </select>
                        <div id="province-error" class="warning"></div>
                    </div>
                    <div class="field-container d-flex flex-column">
                        <input type="text" id="postal" name="postal" placeholder="Postal Code" />
                        <div id="postal-error" class="warning"></div>
                    </div>
                    <div class="field-container d-flex flex-column">
                        <input type="text" id="country" name="country" placeholder="Country" />
                        <div id="country-error" class="warning"></div>
                    </div>
                </div>
            </div>
            <div class="form-field d-none">
                <label class="mb-1">Address<span class="ast">*</span></label>
                <textarea id="address" name="address" placeholder="Address"></textarea>
                <div id="address-error"></div>
            </div>
            <br />
            <div class="form-field">
                <label class="mb-1">Username<span class="ast">*</span></label>
                <input type="text" id="username" name="username" placeholder="Username"/>
                <div id="username-error"></div>
            </div>
            <br />
            <div class="form-field">
                <label class="mb-1">Password<span class="ast">*</span></label>
                <input type="password" id="password" name="password" placeholder="Password" value="" />
                <div id="password-error"></div>
            </div>
            <br />
            <div class="form-field">
                <label class="mb-1">Confirm Password<span class="ast">*</span></label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" value="" />
                <div id="confirm-password-error"></div>
            </div>
            <br />
        </div>
        <input type="submit" name="submit" value="Create Account" class="btn btn-black" />
    </div>
</form>