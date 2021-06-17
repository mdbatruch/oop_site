<form id="order" method="post">
  <ul id="progressbar">
    <li class="active">Delivery</li>
    <li>Billing</li>
    <li>Review</li>
  </ul>
  <fieldset class="step-1">
    <h2 class="fs-title">Enter your Name and Shipping Address</h2>
    <h3 class="fs-subtitle">Enter Contact Details</h3>
      <input type="text" id="first_name" name="first_name" placeholder="First Name" />
      <div id="first_name_warning" class="warning"></div>
      <input type="text" id="last_name" name="last_name" placeholder="Last Name" />
      <div id="last_name_warning" class="warning"></div>
      <input type="text" id="phone" name="phone" placeholder="Phone Number" />
      <div id="phone_warning" class="warning"></div>
      <input type="email" id="email" name="email" placeholder="Email Address" />
      <div id="email_warning" class="warning"></div>
    <h3 class="fs-subtitle">Enter Delivery Address</h3>
      <input type="text" id="street" name="street_name_number" placeholder="Street Name and Number" />
      <div id="street_warning" class="warning"></div>
      <input type="text" id="suite" name="street_name_number" placeholder="Suite or Apartment Number (optional)" />
      <input type="text" id="city" name="city" placeholder="City" />
      <div id="city_warning" class="warning"></div>
      <label for="province">Province</label>
        <select name="province" id="province" class="province">
          <option value="">Select a Province</option>
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
      <input type="text" id="postal" name="postal" placeholder="Postal Code" />
      <div id="postal_warning" class="warning"></div>
      <!-- <div class="next-container"> -->
        <input type="button" name="next" class="next action-button" value="Next" />
      <!-- </div> -->
  </fieldset>
  <fieldset class="step-2">
    <h2 class="fs-title">Select a Payment Method</h2>
    <h3 class="fs-subtitle">Secure Card Payment</h3>
      <div class="field-row">
        <label>Card Type</label>
        <select id="card-type-picker" name="card_type" class="test-billing-card-type error" aria-describedby="card-type-picker-error" aria-invalid="true">
          <option value="">Select a card type</option>
          <option value="001">Visa</option>
          <option value="002">MasterCard</option>
        </select>
        <div id="card_type_warning" class="warning"></div>
      </div>  
      <div class="field-row">
          <label>Card Holder Name</label> <span id="card-holder-name-info"
              class="info"></span><br> <input type="text" id="card-holder-name"
              name="name" class="demoInputBox">
          <div id="card_holder_name_warning" class="warning"></div>
      </div>
      <div class="field-row">
          <label>Card Number</label> <span id="card-number-info"
              class="info"></span><br> <input type="text" id="card-number"
              name="card-number" class="demoInputBox">
          <div id="card_number_warning" class="warning"></div>
      </div>
      <div class="field-row">
          <div class="contact-row column-right">
              <label>Expiry Month / Year</label> <span id="userEmail-info"
                  class="info"></span><br> <select name="month" id="month"
                  class="demoSelectBox">
                  <option value="08">08</option>
                  <option value="09">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
              </select> <select name="year" id="year"
                  class="demoSelectBox">
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
          <div class="contact-row cvv-box">
              <label>CVC</label> <span id="cvv-info" class="info"></span><br>
              <input type="text" name="cvc" id="cvc"
                  class="demoInputBox cvv-input">
              <div id="cvc_warning" class="warning"></div>
          </div>
      </div>
      <input type="button" name="previous" class="previous action-button" value="Previous" />
      <input type="button" name="next" class="next action-button" value="Next" />
  </fieldset>
  <fieldset class="step-3">
    <h2 class="fs-title">Review Your Order</h2>
    <h3 class="fs-subtitle">Make sure everything is in order</h3>
    <div class="info">
      <legend>Contact Details:</legend>
        <div class="name-confirm">Name: <span></span></div>
        <div class="phone-confirm">Phone: <span></span></div>
        <div class="email-confirm">Email: <span></span></div>
      <legend>Address:</legend>
        <div class="street-confirm">Street Name and Number: <span></span></div>
        <div class="suite-confirm">Suite: <span></span></div>
        <div class="city-confirm">City: <span></span></div>
        <div class="province-confirm">Province: <span></span></div>
        <div class="postal-confirm">Postal Code: <span></span></div>
      <legend>Payment Method:</legend>
        <div class="payment-confirm">Card Type: <span></span></div>
        <div class="card-number-confirm">Card Number: <span></span></div>
      <legend>Order Total:</legend>
        <div class="amount-confirm"><span></span></div>
    </div>

    <input type="button" name="previous" class="previous action-button" value="Previous" />
    <input type="submit" name="pay_now" value="Place Order and Confirm Payment"
        id="submit-btn" class="btnAction"
        >

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