<form id="order" method="post">
  <ul id="progressbar">
    <li class="active">Customer Info</li>
    <li>Shipping &amp; Billing</li>
    <li>Review</li>
  </ul>
  <fieldset class="step-1">
    <h2 class="fs-title">Customer Information</h2>
    <h3 class="fs-subtitle d-none"></h3>
    <div class="customer-information">
      <div class="form-inner-container form-name d-flex half">
        <div class="form-field half">
            <label for="first_name">First Name <span class="ast">*</span></label>
            <input type="text" id="first_name" name="first_name" />
            <div id="first_name_warning" class="warning"></div>
        </div>
        <div class="form-field half">
            <label for="last_name">Last Name <span class="ast">*</span></label>
            <input type="text" id="last_name" class="half" name="last_name" />
            <div id="last_name_warning" class="warning"></div>
        </div>
      </div>
      <div class="form-inner-container form-contact d-flex half">
        <div class="form-field half">
            <label for="phone">Phone <span class="ast">*</span></label>
          <input type="text" id="phone" class="half" name="phone" />
          <div id="phone_warning" class="warning"></div>
        </div>
        <div class="form-field half">
            <label for="email">Email <span class="ast">*</span></label>
          <input type="email" id="email" class="half" name="email" />
          <div id="email_warning" class="warning"></div>
        </div>
      </div>
    </div>
    <div class="delivery-information">
    <h2 class="fs-title">Delivery Information</h2>
    <h3 class="fs-subtitle">Enter your delivery address</h3>
    <div class="form-inner-container form-address d-flex flex-column">
      <div class="form-field">
          <label for="street">Street <span class="ast">*</span></label>
          <input type="text" id="street" name="street_name_number" placeholder="Street Name and Number" />
          <div id="street_warning" class="warning"></div>
      </div>
      <div class="form-field">
          <label for="suite" class="d-none">Suite <span class="ast">*</span></label>
          <input type="text" id="suite" name="street_name_number" placeholder="Suite or Apartment Number (optional)" />
      </div>
    </div>
    <div class="form-inner-container form-address-other d-flex flex-column">
      <div class="form-field">
          <label for="city">City <span class="ast">*</span></label>
          <input type="text" id="city" name="city" />
          <div id="city_warning" class="warning"></div>
      </div>
      <div class="form-field">
          <label for="province">Province <span class="ast">*</span></label>
            <select name="province" id="province" class="province">
              <option value=""></option>
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
          <div id="province_warning" class="warning"></div>
      </div>
      <div class="form-field">
          <label for="postal">Postal Code <span class="ast">*</span></label>
          <input type="text" id="postal" name="postal" />
          <div id="postal_warning" class="warning"></div>
      </div>
    </div>
    </div>
    <div class="steps-container-1 d-flex">
      <input type="button" name="next" class="next action-button" value="Next" />
    </div>
  </fieldset>
  <fieldset class="step-2">
    <h2 class="fs-title">Billing Information 
      <span class="inner-title">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
          <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
        </svg>
        Secured Checkout
      </span>
    </h2>
    <h3 class="fs-subtitle">Enter your contact information</h3>
    <div class="card-information">
      <div class="form-inner-container form-card d-flex half">
        <div class="form-field half card-container">
            <label for="credit_number">Credit Card Number <span class="ast">*</span></label>
            <span id="card-number-info"
              class="info"></span> 
              <input type="text" id="card-number"
              name="card-number">
          <div id="card_number_warning" class="warning"></div>
        </div>
        <div class="form-field half card-type">
          <label for="card-type-picker">Card Type</label>
            <select id="card-type-picker" name="card_type" class="test-billing-card-type error" aria-describedby="card-type-picker-error" aria-invalid="true">
              <option value="">Select a card type</option>
              <option value="001">Visa</option>
              <option value="002">MasterCard</option>
            </select>
          <div id="card_type_warning" class="warning"></div>
        </div>
        <div class="form-field half month-year">
            <label>Expiry Date</label> 
            <span id="userEmail-info" class="info d-none"></span>
            <!-- <input type="text" id="month-year" name="month-year" placeholder="MM/YY" /> -->
            <select name="month" id="month" class="demoSelectBox">
                  <option value="08">08</option>
                  <option value="09">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
              </select> 
              <select name="year" id="year" class="demoSelectBox">
                  <option value="21">2021</option>
                  <option value="22">2022</option>
                  <option value="23">2023</option>
                  <option value="24">2024</option>
                  <option value="25">2025</option>
                  <option value="26">2026</option>
                  <option value="27">2027</option>
                  <option value="28">2028</option>
                  <option value="29">2029</option>
                  <option value="30">2030</option>
              </select>
        </div>
        <div class="form-field half cvc">
            <label for="cvv-info">CVC</label> 
            <span id="cvv-info" class="info d-none"></span>
            <input type="text" name="cvc" id="cvc"
                class="cvv-input" placeholder="3 or 4 Digits">
            <div id="cvc_warning" class="warning"></div>
        </div>
        <div class="form-field half">
          <div class="field-row">
              <label for="card-holder-name-info">Name on Credit Card <span class="ast">*</span></label> 
              <input type="text" id="card-holder-name" name="name">
              <div id="card_holder_name_warning" class="warning"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="billing-information">
      <div class="form-inner-container form-billing-address part-1 d-flex flex-column">
        <div class="form-field">
            <label for="billing-address">Address <span class="ast">*</span></label>
            <input type="text" id="billing-address" name="billing-address" placeholder="Street Name and Number" />
            <div id="billing_address_warning" class="warning"></div>
        </div>
        <div class="form-field">
            <label for="billing-suite" class="d-none">Suite <span class="ast">*</span></label>
            <input type="text" id="billing-suite" name="billing_suite_name_number" placeholder="Suite or Apartment Number (optional)" />
        </div>
      </div>
      <div class="form-inner-container form-billing-address part-2 d-flex half">
        <div class="form-field third">
            <div class="field-row">
                <label for="billing-town">Town / City <span class="ast">*</span></label> 
                <input type="text" id="billing-town" name="billing-town">
                <div id="billing_town_warning" class="warning"></div>
            </div>
          </div>
          <div class="form-field third">
            <div class="field-row">
                <label for="billing-province">Province <span class="ast">*</span></label> 
                    <select name="billing-province-info" id="billing-province" class="province">
                    <option value=""></option>
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
                <div id="billing_province_warning" class="warning"></div>
            </div>
          </div>
          <div class="form-field third">
            <div class="field-row">
                <label for="billing-postal">Postal Code <span class="ast">*</span></label> 
                <input type="text" id="billing-postal" name="billing-postal">
                <div id="billing_postal_warning" class="warning"></div>
            </div>
          </div>
      </div>
    </div>
    <div class="shipping-information mt-4">
      <h2 class="fs-title">Shipping Information</h2>
      <div class="form-inner-container form-shipping-information  d-flex flex-column">
          <div class="form-field first d-none">
              <input type="checkbox" id="different-address" name="different-address" value="yes">
              <label for="different-address"> Ship to different address?</label>
          </div>
          <div class="form-field mt-4">
          <h5>Select a Shipping Option:</h5>
            <div id="shipping-option" class="shipping-option d-flex">
              <div class="form-field p-2">
                  <label for="standard-shipping" class="mb-2 d-flex">Standard Shipping <div class="shipping-price">Free</div></label>
                  <input type="radio" id="standard-shipping" name="standard-shipping" value="standard" checked>
                  <span>
                    Free for orders over $80 CAD<br/>
                    Typically arrives between 5-10 business days.
                  </span>
              </div>
              <div class="form-field p-2">
                  <label for="express-shipping" class="mb-2 d-flex">Express Shipping <div class="shipping-price">$25.00</div></label>
                  <input type="radio" id="express-shipping" name="express-shipping" value="express-shipping">
                  <span>
                    Typically arrives between 1-3 business days.<br/>
                    Shipped by Canada Post
                  </span>
              </div>
            </div>
            <div id="shipping_option_warning" class="warning"></div>
          </div>
          <div class="form-field mt-4">
            <label for="order-notes">Order Notes (Optional)</label>
            <input type="text" id="order-notes" name="order-notes" placeholder="Notes about your order, e.g. special notes for your delivery" />
          </div>
      </div>
    </div>
      <div class="steps-container-2 d-flex">
        <input type="button" name="previous" class="previous action-button me-2" value="Previous" />
        <input type="button" name="next" class="next action-button ms-2" value="Next" />
      </div>
  </fieldset>
  <fieldset class="step-3">
    <h2 class="fs-title">Review Your Information</h2>
    <div class="steps-container-3 return d-flex">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
    </svg>
    <input type="button" name="previous" class="previous action-button" value='Edit Billing and Shipping' />
    </div>
    <div class="form-inner-container form-info info container mb-4">
    <div class="row">
      <div class="form-info-field col-12 col-lg-6 col-xxl-4 mt-4">
        <legend>Account Information:</legend>
          <div class="name-confirm"><span></span></div>
          <div class="phone-confirm"><span></span></div>
          <div class="email-confirm"><span></span></div>
          <div class="street-confirm"><span></span></div>
          <div class="suite-confirm"><span></span></div>
          <div class="city-confirm"><span></span></div>
          <div class="province-confirm"><span></span></div>
          <div class="postal-confirm"><span></span></div>
      </div>
      <div class="form-info-field col-12 col-lg-6 col-xxl-4 mt-4">
        <legend>Shipping Method:</legend>
          <div class="shipping-method-confirm"><span></span></div>
      </div>
      <div class="form-info-field col-12 col-lg-6 col-xxl-4 mt-4">
        <legend>Order Notes:</legend>
          <div class="notes-confirm"><span></span></div>
      </div>
      <div class="form-info-field col-12 col-lg-6 col-xxl-4 mt-4">
        <legend>Billing Details:</legend>
        <div class="payment-name-confirm"><span></span></div>
        <div class="payment-address-confirm"><span></span></div>
        <div class="payment-town-confirm"><span></span></div>
        <div class="payment-province-confirm"><span></span></div>
        <div class="payment-postal-confirm"><span></span></div>
      </div>
      <div class="form-info-field col-12 col-lg-6 col-xxl-4 mt-4">
        <legend>Payment Details:</legend>
          <div class="payment-name-confirm"><span></span></div>
          <div class="card-number-confirm"><span></span></div>
          <div class="expiry-date-confirm"><span class="month"></span>/<span class="year"></span></div>
          <div class="payment-confirm"><span></span></div>
      </div>
      <div class="form-info-field col-12 col-lg-6 col-xxl-4 mt-4">
        <legend>Order Total:</legend>
          <div class="amount-confirm"><span></span></div>
      </div>
    </div>
    </div>
    <div class="steps-container-3 complete d-flex">
      <input type="submit" name="pay_now" value="Place Order"
          id="submit-btn" class="btnAction btn btn-black"
          >
    </div>

    <div id="loader">
        <button class="btn btn-primary" type="button" disabled>
          <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
          Processing your Order...
        </button>
    </div>
    <input type='hidden' name='amount' value='0.5'> <input type='hidden'
                        name='currency_code' value='CAD'> <input type='hidden'
                        name='item_name' value='Test Product'> <input type='hidden'
                        name='item_number' value='PHPPOTEG#1'>
  </fieldset>
</form>