<div>
    <div class="mb-5 mt-5">
      <div class="row">
        <div class="col-md-6">
          <h1 style="font-weight:500;">Witaj, <strong><?php echo $first_name . ' ' . $last_name; ?></strong></h1>
          <p class="mt-2 mb-0">Na tej stronie możesz sprawdzić swoją ostatnią aktywnośc w naszym klubie oraz zarządzać swoimi danymi.</p>
          <a href="<?php echo wp_logout_url(get_home_url() ); ?>">Wyloguj się</a>
        </div>
        <div class="col-md-2 offset-md-1">
          <p>Obcena ilość wejść</p> 
          <p><span style="font-size:2.5rem;font-weight:800;"><?php echo $entries_current; ?></span> / <?php echo $entries_maximum; ?></p>
        </div>
        <div class="col-md-3">
        <p class="mb-0">Data ważności karnetu</p>
              <p><?php echo $date_expires; ?></p>
        </div>
      </div>
    </div>
    <p>Jeżeli wprowadzone przez nas dane są nieprawidłowe i nie możesz ich zmienić, prosimy o kontakt z nami.</p> 
    <div class="row">

        <div class="col-md-7">
            <?php echo $form; ?>
        </div>
        <div class="col-md-5">
            <p class="mb-0">Data wykupienia karnetu</p>
              <p><?php echo $date_buy; ?></p>
            <p class="mb-0">Ostanie wejście</p>
              <p><?php echo $date_last_entry; ?></p>
        </div>

    </div>

</div>
