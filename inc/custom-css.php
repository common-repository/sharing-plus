 <style media="screen">

    <?php if ( isset( $this->selected_position['inline'] ) && isset( $this->inline_option['icon_space'] ) ): ?>
    .sharing_plus_buttons.sharing_plus_buttons_inline .sharing-plus-fb-like {
      margin: <?php echo $this->inline_option['icon_space'] == '1' && $this->inline_option['icon_space_value'] != '' ? $this->inline_option['icon_space_value'] . 'px' : ''; ?>;
    }
    <?php endif ?>
     /*inline margin*/
    <?php if ( 'sm-round' == $this->selected_theme && isset( $this->selected_position['inline'] ) ): ?>
    .sharing_plus_buttons.sharing_plus_buttons_inline.sharing-plus-social-sm-round button{
      margin: <?php echo $this->inline_option['icon_space'] == '1' && $this->inline_option['icon_space_value'] != '' ? $this->inline_option['icon_space_value'] . 'px' : ''; ?>;
    }
  <?php endif ?>

  <?php if ( 'simple-round' == $this->selected_theme && isset( $this->selected_position['inline'] ) ) : ?>
    .sharing_plus_buttons.sharing_plus_buttons_inline.sharing-plus-social-simple-round button{
      margin: <?php echo $this->inline_option['icon_space'] == '1' && $this->inline_option['icon_space_value'] != '' ? $this->inline_option['icon_space_value'] . 'px' : ''; ?>;
    }
  <?php endif ?>

  <?php if ( 'round-txt' == $this->selected_theme && isset( $this->selected_position['inline'] )  ) : ?>
    .sharing_plus_buttons.sharing_plus_buttons_inline.sharing-plus-social-round-txt button{
      margin: <?php echo $this->inline_option['icon_space'] == '1' && $this->inline_option['icon_space_value'] != '' ? $this->inline_option['icon_space_value'] . 'px' : ''; ?>;
    }
  <?php endif ?>

  <?php if ( 'round-btm-border' == $this->selected_theme && isset( $this->selected_position['inline'] ) ) : ?>
    .sharing_plus_buttons.sharing_plus_buttons_inline.sharing-plus-social-round-btm-border button{
      margin: <?php echo $this->inline_option['icon_space'] == '1' && $this->inline_option['icon_space_value'] != '' ? $this->inline_option['icon_space_value'] . 'px' : ''; ?>;
    }
  <?php endif ?>

  <?php if ( 'flat-button-border' == $this->selected_theme && isset( $this->selected_position['inline'] ) ) : ?>
    .sharing_plus_buttons.sharing_plus_buttons_inline.sharing-plus-social-flat-button-border button{
      margin: <?php echo $this->inline_option['icon_space'] == '1' && $this->inline_option['icon_space_value'] != '' ? $this->inline_option['icon_space_value'] . 'px' : ''; ?>;
    }
  <?php endif ?>

  <?php if ( 'round-icon' == $this->selected_theme && isset( $this->selected_position['inline'] ) ) : ?>
    .sharing_plus_buttons.sharing_plus_buttons_inline.sharing-plus-social-round-icon button{
      margin: <?php echo $this->inline_option['icon_space'] == '1' && $this->inline_option['icon_space_value'] != '' ? $this->inline_option['icon_space_value'] . 'px' : ''; ?>;
    }

  <?php endif ?>

     <?php if ( 'simple-icons' == $this->selected_theme && isset( $this->selected_position['inline'] ) && isset( $this->inline_option['icon_space'] ) ) : ?>
     .sharing_plus_buttons.sharing_plus_buttons_inline.sharing-plus-social-simple-icons button{
         margin: <?php echo $this->inline_option['icon_space'] == '1' && $this->inline_option['icon_space_value'] != '' ? $this->inline_option['icon_space_value'] . 'px' : ''; ?>;
     }

     <?php endif ?>
     /*margin-digbar*/

  <?php if ( 'sm-round' == $this->selected_theme && isset( $this->selected_position['sidebar'] ) ) : ?>
    div[class*="sharing-plus-buttons-float"].sharing_plus_buttons.sharing-plus-social-sm-round button{
      margin: <?php echo $this->sidebar_option['icon_space'] == '1' && $this->sidebar_option['icon_space_value'] != '' ? $this->sidebar_option['icon_space_value'] . 'px 0' : ''; ?>;
    }
  <?php endif ?>

  <?php if ( 'simple-round' == $this->selected_theme && isset( $this->selected_position['sidebar'] ) ) : ?>
    div[class*="sharing-plus-buttons-float"].sharing_plus_buttons.sharing-plus-social-simple-round button{
      margin: <?php echo $this->sidebar_option['icon_space'] == '1' && $this->sidebar_option['icon_space_value'] != '' ? $this->sidebar_option['icon_space_value'] . 'px 0' : ''; ?>;
    }
  <?php endif ?>

  <?php if ( 'round-txt' == $this->selected_theme && isset( $this->selected_position['sidebar'] ) ) : ?>
  div[class*="sharing-plus-buttons-float"].sharing_plus_buttons.sharing-plus-social-round-txt button{
    margin: <?php echo $this->sidebar_option['icon_space'] == '1' && $this->sidebar_option['icon_space_value'] != '' ? $this->sidebar_option['icon_space_value'] . 'px 0' : ''; ?>;
  }
  <?php endif ?>

  <?php if ( 'round-btm-border' == $this->selected_theme && isset( $this->selected_position['sidebar'] ) ) : ?>
    div[class*="sharing-plus-buttons-float"].sharing_plus_buttons.sharing-plus-social-round-btm-border button{
      margin: <?php echo $this->sidebar_option['icon_space'] == '1' && $this->sidebar_option['icon_space_value'] != '' ? $this->sidebar_option['icon_space_value'] . 'px 0' : ''; ?>;
    }
  <?php endif ?>

 <?php if ( 'round-icon' == $this->selected_theme && isset( $this->selected_position['sidebar'] ) ) : ?>
   div[class*="sharing-plus-buttons-float"].sharing_plus_buttons.sharing-plus-social-round-icon button{
     margin: <?php echo $this->sidebar_option['icon_space'] == '1' && $this->sidebar_option['icon_space_value'] != '' ? $this->sidebar_option['icon_space_value'] . 'px 0' : ''; ?>;
   }
 <?php endif ?>

   <?php if ( 'simple-icons' == $this->selected_theme && isset( $this->selected_position['sidebar'] ) ) : ?>
   div[class*="sharing-plus-buttons-float"].sharing_plus_buttons.sharing-plus-social-simple-icons button{
       margin: <?php echo $this->sidebar_option['icon_space'] == '1' && $this->sidebar_option['icon_space_value'] != '' ? $this->sidebar_option['icon_space_value'] . 'px 0' : ''; ?>;
   }
   div[class*="sharing-plus-buttons-float"].sharing_plus_buttons.sharing-plus-social-simple-icons .sharing-plus-fb-like{
       margin: <?php echo $this->sidebar_option['icon_space'] == '1' && $this->sidebar_option['icon_space_value'] != '' ? $this->sidebar_option['icon_space_value'] . 'px 0' : ''; ?>;
   }
   <?php endif ?>

   <?php if ( isset( $this->selected_position['sidebar'] ) && $this->sidebar_option['icon_space'] == '1' ) : ?>
   div[class*="sharing-plus-buttons-float"].sharing_plus_buttons .sharing-plus-fb-like{
       margin: <?php echo $this->sidebar_option['icon_space'] == '1' && $this->sidebar_option['icon_space_value'] != '' ? $this->sidebar_option['icon_space_value'] . 'px 0' : ''; ?>;
   }
   <?php endif ?>


</style>
