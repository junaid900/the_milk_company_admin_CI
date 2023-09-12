<style>
    .loading {
      height: 0;
      width: 0;
      padding: 9px;
      border: 3px solid #ccc;
      border-right-color: #888;
      border-radius: 22px;
      -webkit-animation: rotate 1s infinite linear;
      position: absolute;
      left: 44%;
      top: 27%;
    }
    
    @-webkit-keyframes rotate {
      /* 100% keyframe for  clockwise. 
         use 0% instead for anticlockwise */
      100% {
        -webkit-transform: rotate(360deg);
      }
    }
    .upload-btn-img {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }

    .upload-btn-img input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        height: 100%;
    }

    .img-thumbnail,.image_one,.image_two,.image_three {
        opacity: 1;
        transition: opacity .25s ease-in-out;
        -moz-transition: opacity .25s ease-in-out;
        -webkit-transition: opacity .25s ease-in-out;
        cursor: pointer;
        width: 100%;
        object-fit: cover;
    }
    .fix_height{
        height: 180px;
    }
    .auto_height{
        height: 360px;
    }
    .main_height{
         height: 120px;
    }

    .upload-btn-img:hover .img-thumbnail {
        opacity: 0.7;
        cursor: pointer;
    }

    .upload-btn-img:hover input {
        cursor: pointer;
    }

    .pc-fonts {
        font-size: 14px;
        font-weight: bold;
    }

    .pc-button-item {
        margin-right: 7px;
        margin-top: 10px;
    }

    fieldset {
        border: 0;
        padding: 0;
        margin-bottom: 1.5rem;
    }

    legend {
        font-size: 14px;
        margin-bottom: 10px;
    }

    .radios-wrapper .radio-item {
        position: relative;
        display: inline-block;
        margin-right: 10px;
        font-size: 16px;
    }

    .radios-wrapper .radio-item:last-child {
        margin-right: 0;
    }

    .radios-wrapper .radio-item__label-text, .radios-wrapper .radio-item__text-input-wrapper {
        position: relative;
        display: inline-block;
        padding: 0.5em 1em;
        border: 2px solid #ebebeb !important;
        border-radius: 7px;
        background: #fff;
        color: #444;
        font-weight: 400;
        transition: all 0.1s ease-in;
    }

    .radios-wrapper .radio-item__label-text:hover, .radios-wrapper .radio-item__text-input-wrapper:hover {
        border: 1px solid #40a5b0 !important;

    }

    .radios-wrapper .radio-item__input {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        overflow: hidden;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .radios-wrapper .radio-item__input:checked + .radio-item__label-text {
        border: 1px solid #40a5b0 !important;
        color: #40a5b0;
    }

    .radios-wrapper .radio-item__input:focus + .radio-item__label-text {
        border: 1px solid #40a5b0 !important;
        color: #40a5b0;
    }

    .radios-wrapper .radio-item__input:focus + .radio-item__label-text:after {
        position: absolute;
        top: -3px;
        right: -3px;
        bottom: -3px;
        left: -3px;
        /*border: 3px solid #20b68a !important; */
        border-radius: 1em;
        content: "";
    }

    .radios-wrapper .radio-item__text-input {
        border: 0;
        font-weight: 400;
        width: auto;
        background: inherit;
        padding: 0;
    }

    .radios-wrapper .radio-item__text-input:focus {
        outline: none;
    }

    .radios-wrapper .radio-item__text-input:focus .radio-item__text-input-wrapper {
        border: 2px solid #1cb487 !important;
        background: rgba(32, 201, 151, 0.33);
        color: #20c997;
    }

    .radios-wrapper .radio-item__text-input-wrapper:focus-within {
        border: 2px solid #1daf84 !important;
        background: rgba(32, 201, 151, 0.33);
        color: #20c997;
    }

    .radios-wrapper .radio-item__text-input-wrapper:focus-within:hover {
        border-color: #1fb488 !important;
    }

    .radios-wrapper .radio-item__text-input-wrapper:focus-within:after {
        position: absolute;
        top: -3px;
        right: -3px;
        bottom: -3px;
        left: -3px;
        border: 3px solid #1aa77d !important;
        border-radius: 1em;
        content: "";
    }


    input[type=radio]:checked ~ .radio-item__label-text .reveal-if-active,
    input[type=checkbox]:checked ~ .radio-item__label-text .reveal-if-active {
        opacity: 1;
        display: inline-block;
        max-width: none;
        max-height: none;
        overflow: visible;
    }

    input[type=radio]:checked ~ .radio-item__label-text .reveal-if-active input[type=tel],
    input[type=checkbox]:checked ~ .radio-item__label-text .reveal-if-active input[type=tel] {
        background: inherit;
        border: 0;
        padding: 0;
    }

    input[type=radio]:checked ~ .radio-item__label-text .hide-if-active,
    input[type=checkbox]:checked ~ .radio-item__label-text .hide-if-active {
        opacity: 0;
        width: 0;
    }

    .pr_attr {
        opacity: 1 !important;
        position: relative;
        top: 2.5px;
        right: 4px;
    }

    input[type="radio"] {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        display: inline-block;
        width: 14px;
        height: 14px;
        padding: 2px;
        background-clip: content-box;
        border: 1px solid #40a5b0;
        background-color: #40a5b0;
        border-radius: 50%;
    }

    /* appearance for checked radiobutton */
    input[type="radio"]:checked {
        background-color: #40a5b0;
    }

    .btn-outline-success.disabled, .btn-outline-success:disabled {
        color: #41a5b0 !important;
        border-color: #41a5b0 !important;
    }
    .text-area-container{
        padding:0px;
    }
    .pd_zero{
        padding-left: 0px;
    }
    .main_img{
      padding: 0em 1em;
    }
   
</style>