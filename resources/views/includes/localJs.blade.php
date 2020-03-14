

<script>


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    
      var $form = $('#msform');
      
      $form.find('.subscribe').on('click', payWithStripe);
      
      /* If you're using Stripe for payments */
      function payWithStripe(e) {
          e.preventDefault();
          
          /* Abort if invalid form data */
          if (!validator.form()) {
              return;
          }
    
      
          /* Visual feedback */
          $form.find('.subscribe').html('Validating <i class="fa fa-spinner fa-pulse"></i>').prop('disabled', true);
      
          var PublishableKey = 'pk_test_hp7KkAN9l6j9LbMuKi7x1wFc00TlyZdHGN'; // Replace with your API publishable key
          Stripe.setPublishableKey(PublishableKey);
          
          /* Create token */
          var expiry = $form.find('[name=cardExpiry]').payment('cardExpiryVal');
          var ccData = {
              number: $form.find('[name=cardNumber]').val().replace(/\s/g,''),
              cvc: $form.find('[name=cardCVC]').val(),
              exp_month: expiry.month, 
              exp_year: expiry.year
          };
          
          Stripe.card.createToken(ccData, function stripeResponseHandler(status, response) {
              if (response.error) {
                  /* Visual feedback */
                  $form.find('.subscribe').html('Try again').prop('disabled', false);
                  /* Show Stripe errors on the form */
                  $form.find('.payment-errors').text(response.error.message);
                  $form.find('.payment-errors').closest('.row').show();
              } else {
                  /* Visual feedback */
                  $form.find('.subscribe').html('Processing <i class="fa fa-spinner fa-pulse"></i>');
                  /* Hide Stripe errors on the form */
                  $form.find('.payment-errors').closest('.row').hide();
                  $form.find('.payment-errors').text("");
                  // response contains id and card, which contains additional card details            
                  console.log(response.id);
                  console.log(response.card);
                  var token = response.id;
                  
                  var data= { token:token,
                              planType:$form.find("input[name=PlanType]:checked").val()};
                  // AJAX - you would send 'token' to your server here.
                  $.post('{{ route("PayWithStripe") }}',data)
                      // Assign handlers immediately after making the request,
                      .done(function(data, textStatus, jqXHR) {
                          $form.find('.subscribe').html('Payment successful you will redirect to Dashboard Soon <i class="fa fa-check"></i>');
                          var delay = 2000; 
                          var url = '{{ route("Dashboard") }}'
                          setTimeout(function(){ window.location = url; }, delay);
                      })
                      .fail(function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                          $form.find('.subscribe').html('There was a problem').removeClass('success').addClass('error');
                          /* Show Stripe errors on the form */
                          $form.find('.payment-errors').text('Try refreshing the page and trying again.');
                          $form.find('.payment-errors').closest('.row').show();
                      });
              }
          });
      }
      /* Fancy restrictive input formatting via jQuery.payment library*/
      $('input[name=cardNumber]').payment('formatCardNumber');
      $('input[name=cardCVC]').payment('formatCardCVC');
      $('input[name=cardExpiry').payment('formatCardExpiry');
      
      /* Form validation using Stripe client-side validation helpers */
      jQuery.validator.addMethod("cardNumber", function(value, element) {
          return this.optional(element) || Stripe.card.validateCardNumber(value);
      }, "Please specify a valid credit card number.");
      
      jQuery.validator.addMethod("cardExpiry", function(value, element) {    
          /* Parsing month/year uses jQuery.payment library */
          value = $.payment.cardExpiryVal(value);
          return this.optional(element) || Stripe.card.validateExpiry(value.month, value.year);
      }, "Invalid expiration date.");
      
      jQuery.validator.addMethod("cardCVC", function(value, element) {
          return this.optional(element) || Stripe.card.validateCVC(value);
      }, "Invalid CVC.");
      
      validator = $form.validate({
          rules: {
              cardNumber: {
                  required: true,
                  cardNumber: true            
              },
              cardExpiry: {
                  required: true,
                  cardExpiry: true
              },
              cardCVC: {
                  required: true,
                  cardCVC: true
              }
          },
          highlight: function(element) {
              $(element).closest('.form-control').removeClass('success').addClass('error');
          },
          unhighlight: function(element) {
              $(element).closest('.form-control').removeClass('error').addClass('success');
          },
          errorPlacement: function(error, element) {
              $(element).closest('.form-group').append(error);
          }
      });
      
      paymentFormReady = function() {
          if ($form.find('[name=cardNumber]').hasClass("success") &&
              $form.find('[name=cardExpiry]').hasClass("success") &&
              $form.find('[name=cardCVC]').val().length > 1) {
              return true;
          } else {
              return false;
          }
      }
      
      $form.find('.subscribe').prop('disabled', true);
      var readyInterval = setInterval(function() {
          if (paymentFormReady()) {
              $form.find('.subscribe').prop('disabled', false);
              clearInterval(readyInterval);
          }
      }, 250);
      
      
      
      
      
      
      //PayPal Pay
    
      paypal.Button.render({
            env: 'sandbox', // Or 'production'
            style: {
              size: 'large',
              color: 'gold',
              shape: 'pill',
            },
            // Set up the payment:
            // 1. Add a payment callback
            payment: function(data, actions) {
              // 2. Make a request to your server
              return actions.request({
                method:'post',
                url:'{{ route("CheckPayment") }}',
                data:{PlanType:$form.find("input[name=PlanType]:checked").val()},
                headers: {
                 'x-csrf-token':"{{ csrf_token() }}"
                  }
              })
                .then(function(res) {
                  // 3. Return res.id from the response
                  // console.log(res);
                  return res.id;
                });
            },
            // Execute the payment:
            // 1. Add an onAuthorize callback
            onAuthorize: function(data, actions) {
              // 2. Make a request to your server
              console.log(data)
              return actions.request({
                method:'post',
                url:"{{ route('ExecPayment') }}",
                data:{
                paymentID: data.paymentID,
                payerID:   data.payerID,
                PlanType :$form.find("input[name=PlanType]:checked").val()
              },
              headers: {
                 'x-csrf-token':"{{ csrf_token() }}"
                  }
                  })
                .then(function(res) {
                  // 3. Set TimeOut and redirect to Dashboard
                  var delay = 2000; 
                  var url = '{{ route("Dashboard") }}'
                  setTimeout(function(){ window.location = url; }, delay);
              
                });
            }
          }, '#paypal-button');
    
    
        </script>
    
      
