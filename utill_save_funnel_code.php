<?php 
include 'util_config.php';
include 'util_session.php';


$code = '<div id=xxx$#all_the_anwerxxx$# class=xxx$#answer-container defalte_bg height_fixedxxx$#>

<div id=xxx$#my_funnel_headerxxx$# class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#>

    <div id=xxx$#logo_1xxx$# class=xxx$#open_image col-lg-12 col-xlg-12 col-md-12 xxx$# style=xxx$#text-align: center;xxx$#>
        <img src=xxx$#./assets/images/logo-icon.pngxxx$# alt=xxx$#xxx$# class=xxx$#dark-logo logo_padding logo_height_and_widthxxx$#>
    </div> 
</div>                                        




<div id=xxx$#answer-1xxx$# class=xxx$#answer active  mb-4  xxx$#>
    <div class=xxx$#dropzone rows-containerxxx$# id=xxx$#xxx$# ondragover=xxx$#allowDrop(event)xxx$# ondragleave=xxx$#dragLeave(event)xxx$# ondrop=xxx$#drop(event)xxx$#>


        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >

            <div id=xxx$#xxx$#   class=xxx$#col-lg-12 col-xlg-12 col-md-4 xxx$# >

            </div>
        </div>

        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnelxxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                <p  class=xxx$#xxx$# >📍 Searched for [job title] in [city].</p>
            </div>
        </div>


        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$# >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_1xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;center;font-size: 40px;font-weight: boldxxx$# >
                <p >Delight customers with wood art.</p>
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$#draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_2xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-12 xxx$# style=xxx$#text-align: center;center;font-size: 14px;xxx$# >
                <p>... And be generously remunerated, plus additional benefits.</p>
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#image_1xxx$# class=xxx$# open_image col-lg-12 col-xlg-12 col-md-12  xxx$# style=xxx$#text-align: center;xxx$#>
                <img src=xxx$#./images/funnel1.pngxxx$#  alt=xxx$#xxx$# class=xxx$#dark-logo logo_padding fit_to_divxxx$# />
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#image_2xxx$# class=xxx$# open_image col-lg-12 col-xlg-12 col-md-12  xxx$# style=xxx$#text-align: center;xxx$#>
                <img src=xxx$#./images/dummpy.pngxxx$#  alt=xxx$#xxx$# class=xxx$#dark-logo logo_padding fit_to_divxxx$# />
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#btn_1xxx$# class=xxx$#open_button col-lg-12 col-xlg-12 col-md-12 xxx$# style=xxx$#text-align: center;xxx$#> 
                <a onclick=xxx$#showAnswer_20(xxxn4$#2xxxn4$#)xxx$# href=xxx$##xxx$# contenteditable=xxx$#truexxx$# class=xxx$#btn btn-info btn-rounded waves-effect waves-light xxx$#>i want to learn more </a>

            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_3xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                <p>👷 From now on 🕐 full time 💳 XX € / hour.</p>
            </div>
        </div>

        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_12.0xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                <p  class=xxx$#xxx$# >your advantages.</p>
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$# >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_12.01xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-12  xxx$#  style=xxx$#text-align: center;center;font-size: 17px;font-weight: boldxxx$# >
                <p >This is what awaits you at Muster GmbH</p>
            </div>
        </div>



        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div class=xxx$#col-lg-12 col-xlg-12 col-md-4 text-centerxxx$#>
                <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#col-lg-6 col-xlg-6 col-md-6 text-center xxx$# draggable=xxx$#truexxx$#  >

                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>

                            <div id=xxx$#icon_0xxx$#  class=xxx$#icon_open col-lg-12 col-xlg-12 col-md-12  xxx$# style=xxx$#text-align: center;center;font-size: 45px;xxx$#>
                                <i class=xxx$#fas fa-coinsxxx$#></i>
                            </div>
                        </div>

                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>

                            <div contenteditable=xxx$#truexxx$#  id =xxx$#p_funnel_4xxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-12    xxx$# style=xxx$#text-align: center;font-size: 17px;font-weight: boldxxx$# >
                                <p > Salary & Supplements.</p>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div contenteditable=xxx$#truexxx$#  id =xxx$#p_funnel_5xxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-12 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$#>
                                <p>Good pay according to tariff, Christmas bonus, and generous holiday bonuses</p>
                            </div>
                        </div>

                    </div>

                    <div class=xxx$#col-lg-6 col-xlg-6 col-md-6 text-centerxxx$# draggable=xxx$#truexxx$#>

                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>

                            <div id=xxx$#icon_1xxx$# class=xxx$#icon_open col-lg-12 col-xlg-12 col-md-4xxx$# style=xxx$#text-align: center;center;center;font-size: 45px;xxx$#>
                                <i   class=xxx$# fas fa-toolsxxx$#></i>
                            </div>

                        </div>

                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_6xxx$#  contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4    xxx$# style=xxx$#text-align: center;center;font-size: 17px;font-weight: boldxxx$# >
                                <p >The best tool.</p>
                            </div>
                        </div>


                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_7xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$#>
                                <p>Only work with the best tools and quality safety clothinge</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div  class=xxx$#col-lg-12 col-xlg-12 col-md-4 text-centerxxx$#>
                <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#col-lg-6 col-xlg-6 col-md-6 text-center xxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#icon_2xxx$# class=xxx$#icon_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 45px;xxx$# >
                                <i class=xxx$#fas fa-hands-helpingxxx$#></i>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#p_funnel_8xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4   xxx$# style=xxx$#text-align: center;font-size: 17px;font-weight: boldxxx$# >
                                <p > Positive working environment.</p>
                            </div>
                        </div>

                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_9xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$#>
                                <p>Having fun in a team of 20 and delivering good work. Regular events are on our schedule</p>
                            </div>
                        </div>

                    </div>
                    <div class=xxx$#col-lg-6 col-xlg-6 col-md-6 text-centerxxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#icon_3xxx$# class=xxx$#icon_open col-lg-12 col-xlg-12 col-md-4  xxx$# style=xxx$#text-align: center;font-size: 45px;xxx$# >
                                <i class=xxx$#fas fa-map-marked-altxxx$#></i>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_10xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4  bold_text text_size_minimumxxx$# style=xxx$#text-align: center;font-size: 17px;font-weight: boldxxx$# >
                                <p >Stable workplace</p>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_11xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                                <p>A crisis-proof and stationary workplace, without trips throughout Germany</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div class=xxx$#col-lg-12 col-xlg-12 col-md-4 text-centerxxx$#>
                <div class=xxx$#rowxxx$#>


                    <div class=xxx$#col-lg-4 col-xlg-4 col-md-4 xxx$#>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#audio_1xxx$#  class=xxx$#audio_open col-lg-12 col-xlg-12 col-md-4 text_size_bigxxx$# style=xxx$#text-align: center;xxx$# >
                                <img  src=xxx$#./assets/images/colleagues3.pngxxx$#  alt=xxx$#xxx$# class=xxx$#border_is img-circle  logo_height_and_widthxxx$# />
                                <br>

                                <audio controls controls class=xxx$#audio-tagxxx$# type=xxx$#audio/mp3xxx$# src=xxx$#images/testing.mp3xxx$#>
                                    Your browser does not support the audio element.
                                </audio>



                            </div>

                        </div>


                    </div>
                    <div class=xxx$#col-lg-8 col-xlg-8 col-md-8 text-centerxxx$#>

                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#icon_5xxx$# class=xxx$#icon_open col-lg-12 col-xlg-12 col-md-4  xxx$# style=xxx$#text-align: left;font-size: 45px;xxx$#>
                                <i class=xxx$#fas fa-quote-leftxxx$#></i>
                            </div>
                        </div>

                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_12xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4xxx$# style=xxx$#text-align: center;center;font-size: 14pxxxx$# >
                                <p>We want you to feel comfortable with us... [Empathy and personal words from the business owner] Max Mustermann, Managing Director of Muster GmbH
                                </p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>





        <!-- Drop Indicator -->
        <div class=xxx$#drop-indicatorxxx$#></div>


    </div>
    <!--//end1-->
</div>



<div id=xxx$#answer-2xxx$# class=xxx$#answer mb-4  xxx$#>
    <div class=xxx$#dropzone rows-containerxxx$# id=xxx$#xxx$# ondragover=xxx$#allowDrop(event)xxx$# ondragleave=xxx$#dragLeave(event)xxx$# ondrop=xxx$#drop(event)xxx$#>
        <!--                                            //logo-->
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >

            <div id=xxx$#xxx$#   class=xxx$#col-lg-12 col-xlg-12 col-md-4 xxx$# >

            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_2.001xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                <p  class=xxx$#xxx$# >We introduce ourselves briefly.</p>
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$# >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_2.002xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;center;font-size: 40px;font-weight: boldxxx$# >
                <p >This is us. The Sample GmbH.</p>
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#image_2.003xxx$# class=xxx$# open_image col-lg-12 col-xlg-12 col-md-12  xxx$# style=xxx$#text-align: center;xxx$#>
                <img src=xxx$#./images/funnel2.pngxxx$#  alt=xxx$#xxx$# class=xxx$#dark-logo logo_padding fit_to_divxxx$# />
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#btn_2.004xxx$# class=xxx$#open_button col-lg-12 col-xlg-12 col-md-12 xxx$# style=xxx$#text-align: center;xxx$#> 
                <a  onclick=xxx$#showAnswer_20(xxxn4$#3xxxn4$#)xxx$# href=xxx$##xxx$# contenteditable=xxx$#truexxx$# class=xxx$#btn btn-info btn-rounded waves-effect waves-light xxx$#>Apply now (duration: 2min) </a>

            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_2.005xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                <p  class=xxx$#xxx$# >[Storytelling] It started with the vision [e.g. manual work] in the [industry]. Great [e.g. to create wooden works of art] that everyone ... [vision].
                    Behind the great products is an even better team. X employees all work together towards the goal... [recommendation: max. 500 characters]</p>
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_2.006xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                <p  class=xxx$#xxx$# >Your tasks</p>
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$# >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_2.007xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;center;font-size: 40px;font-weight: boldxxx$# >
                <p >Your everyday work with us.</p>
            </div>
        </div>


        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div  class=xxx$#col-lg-12 col-xlg-12 col-md-4 text-centerxxx$#>
                <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#col-lg-6 col-xlg-6 col-md-6 text-center xxx$# draggable=xxx$#truexxx$#   >


                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#icon_2.009xxx$# class=xxx$#icon_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 45px;xxx$# >
                                <i class=xxx$#fas fa-homexxx$#></i>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#p_funnel_2.010xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4   xxx$# style=xxx$#text-align: center;font-size: 17px;font-weight: boldxxx$# >
                                <p >Montage</p>
                            </div>
                        </div>

                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.011xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$#>
                                <p>Together with the team, build the resulting wooden works of art for customers</p>
                            </div>
                        </div>

                    </div>
                    <div class=xxx$#col-lg-6 col-xlg-6 col-md-6 text-centerxxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#icon_2.012xxx$# class=xxx$#icon_open col-lg-12 col-xlg-12 col-md-4  xxx$# style=xxx$#text-align: center;font-size: 45px;xxx$# >
                                <i class=xxx$#fas fa-carxxx$#></i>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.013xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4  xxx$# style=xxx$#text-align: center;font-size: 17px;font-weight: boldxxx$# >
                                <p >delivery</p>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.014xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                                <p>Transport our works to the customers with the latest vehicles and delivery technology</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div  class=xxx$#col-lg-12 col-xlg-12 col-md-4 text-centerxxx$#>
                <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#col-lg-6 col-xlg-6 col-md-6 text-center xxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#icon_2.020xxx$# class=xxx$#icon_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 45px;xxx$# >
                                <i class=xxx$#fas fa-file-altxxx$#></i>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#p_funnel_2.021xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4   xxx$# style=xxx$#text-align: center;font-size: 17px;font-weight: boldxxx$# >
                                <p >quality check</p>
                            </div>
                        </div>

                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.022xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$#>
                                <p>We work according to the highest quality standard, which is why quality checks are carried out regularly</p>
                            </div>
                        </div>

                    </div>
                    <div class=xxx$#col-lg-6 col-xlg-6 col-md-6 text-centerxxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#icon_2.023xxx$# class=xxx$#icon_open col-lg-12 col-xlg-12 col-md-4  xxx$# style=xxx$#text-align: center;font-size: 45px;xxx$# >
                                <i class=xxx$#fas fa-phonexxx$#></i>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.024xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4   xxx$# style=xxx$#text-align: center;font-size: 17px;font-weight: boldxxx$# >
                                <p >customer talks</p>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.025xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                                <p>Gehe direkt auf die Wünsche der Kunden ein und pflege telefonischen und realen Kontakt mit ihnen</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>



        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div  class=xxx$#col-lg-12 col-xlg-12 col-md-4 text-centerxxx$#>
                <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#col-lg-6 col-xlg-6 col-md-6 text-center xxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#image_2.033xxx$# class=xxx$# open_image col-lg-12 col-xlg-12 col-md-12  xxx$# style=xxx$#text-align: center;xxx$#>
                                <img src=xxx$#./images/funnel3.pngxxx$#  alt=xxx$#xxx$# class=xxx$#dark-logo logo_padding fit_to_divxxx$# />
                            </div>
                        </div>
                    </div>
                    <div class=xxx$#col-lg-6 col-xlg-6 col-md-6 text-centerxxx$# draggable=xxx$#truexxx$#  >

                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#image_2.034xxx$# class=xxx$# open_image col-lg-12 col-xlg-12 col-md-12  xxx$# style=xxx$#text-align: center;xxx$#>
                                <img src=xxx$#./images/funnel4.pngxxx$#  alt=xxx$#xxx$# class=xxx$#dark-logo logo_padding fit_to_divxxx$# />
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>


        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_2.2000xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open padding_non col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                <p  class=xxx$#padding_non margen_nonxxx$# >your next steps</p>
            </div>
        </div>
        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$# >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_2.3000xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open margen_non padding_non col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;center;font-size: 40px;font-weight: boldxxx$# >
                <p  class=xxx$#padding_non margen_nonxxx$#  >Your way to your dream job</p>
            </div>
        </div>


        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div  class=xxx$#col-lg-12 col-xlg-12 col-md-4 text-centerxxx$#>
                <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#col-lg-4 col-xlg-4 col-md-4 text-center xxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$# >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.22000xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open margen_non padding_non col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;center;font-size: 40px;font-weight: boldxxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$#  >1.</p>
                            </div>
                        </div>

                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.2220xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open padding_non col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 17px;xxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$# >2 min Answer questions</p>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$# >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.22223xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open margen_non padding_non col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;center;font-size: 10px;xxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$#  >Answer a few questions and submit your application</p>
                            </div>
                        </div>

                    </div>
                    <div class=xxx$#col-lg-4 col-xlg-4 col-md-4 text-center xxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$# >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.30001xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open margen_non padding_non col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;center;font-size: 40px;font-weight: boldxxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$#  >2.</p>
                            </div>
                        </div>

                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.30023xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open padding_non col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 17px;xxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$# >Prompt feedback</p>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$# >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.23340xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open margen_non padding_non col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;center;font-size: 10px;xxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$#  >We will evaluate your answers and get back to you</p>
                            </div>
                        </div>

                    </div>
                    <div class=xxx$#col-lg-4 col-xlg-4 col-md-4 text-center xxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$# >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.200134xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open margen_non padding_non col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;font-size: 40px;font-weight: boldxxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$#  >3.</p>
                            </div>
                        </div>

                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.39380xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open padding_non col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 17px;xxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$# >You have your dream job</p>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$# >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.78327221xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open margen_non padding_non col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;center;font-size: 10px;xxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$#  >If everything fits, we look forward to welcoming you to the team soon</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>


        <div class=xxx$#drop-indicatorxxx$#></div>

    </div>

    <!--//end1-->
</div>
<div id=xxx$#answer-3xxx$# class=xxx$#answer mb-4 xxx$#>
    <div class=xxx$#dropzone rows-containerxxx$# id=xxx$#xxx$# ondragover=xxx$#allowDrop(event)xxx$# ondragleave=xxx$#dragLeave(event)xxx$# ondrop=xxx$#drop(event)xxx$#>

        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >

            <div id=xxx$#xxx$#   class=xxx$#col-lg-12 col-xlg-12 col-md-4 xxx$# >

            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_2.300713545xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 24px;xxx$# >
                <p  class=xxx$#xxx$# >Do you have an apprenticeship / study in the field of XY?</p>
            </div>
        </div>
        <div class=xxx$#row margen_non   draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>

            <div class=xxx$# col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#custom_container row   draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div  onclick=xxx$#showAnswer_20(xxxn4$#4xxxn4$#)xxx$# id=xxx$#image_2.90331xxx$# class=xxx$#single_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>
                        <div class=xxx$#d-flex align-items-centerxxx$#>
                            <div class=xxx$#mr-2xxx$#>
                                <i class=xxx$#fas fa-2x fa-angle-rightxxx$#></i> <!-- Small Icon -->
                            </div>
                            <div contenteditable=xxx$#truexxx$#  class=xxx$#flex-grow-1xxx$# style=xxx$#text-align: leftxxx$# >
                                <p class=xxx$#m-0xxx$#>Yes, I have</p> <!-- Text Element -->
                            </div>
                            <div  class=xxx$#ml-2 single_selection_iconxxx$#>
                                <i class=xxx$#fas  fa-thumbs-upxxx$#></i> <!-- Big Icon -->
                            </div>
                        </div>


                    </div>
                </div>

            </div>


            <div class=xxx$# col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#custom_container row   draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div onclick=xxx$#showAnswer_20(xxxn4$#disqualificationxxxn4$#)xxx$#  id=xxx$#image_2.90332xxx$# class=xxx$#single_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>
                        <div class=xxx$#d-flex align-items-centerxxx$#>
                            <div class=xxx$#mr-2xxx$#>
                                <i class=xxx$#fas fa-2x fa-angle-rightxxx$#></i> <!-- Small Icon -->
                            </div>
                            <div contenteditable=xxx$#truexxx$#  class=xxx$#flex-grow-1xxx$# style=xxx$#text-align: leftxxx$# >
                                <p class=xxx$#m-0xxx$#>No I havenxxxn4$#t</p> <!-- Text Element -->
                            </div>
                            <div  class=xxx$#ml-2 single_selection_iconxxx$#>
                                <i class=xxx$#fas  fa-thumbs-down xxx$#></i> <!-- Big Icon -->
                            </div>
                        </div>


                    </div>
                </div>

            </div>

            <div id=xxx$#single_plus_id_3xxx$# class=xxx$#single_plus col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >

                <div class=xxx$# row xxx$#   >

                    <div id=xxx$#image_2.90333xxx$# class=xxx$#   margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>

                        <div class=xxx$#custom-column_add xxx$#>
                            <i class=xxx$#fas fa-2x fa-plusxxx$#></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_2.3007113xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                <p  class=xxx$#xxx$# >Employee ❤️ Sample GmbH</p>
            </div>
        </div>

        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$# >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_2.3135000xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open margen_non padding_non col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;center;font-size: 40px;font-weight: boldxxx$# >
                <p  class=xxx$#padding_non margen_nonxxx$#  >What your future colleagues report</p>
            </div>
        </div>


        <div class=xxx$#row margen_non   draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>

            <div class=xxx$# col-lg-4 col-xlg-4 col-md-4 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div id=xxx$#audio_2.22002xxx$#  class=xxx$#audio_open col-lg-12 col-xlg-12 col-md-4 text_size_bigxxx$# style=xxx$#text-align: center;xxx$# >
                        <img  src=xxx$#./images/colleagues1.pngxxx$#  alt=xxx$#xxx$# class=xxx$#border_is img-circle  logo_height_and_widthxxx$# />
                        <br>

                        <audio controls controls class=xxx$#audio-tagxxx$# type=xxx$#audio/mp3xxx$# src=xxx$#images/testing.mp3xxx$#>
                            Your browser does not support the audio element.
                        </audio>



                    </div>

                </div>

                <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div id=xxx$#p_funnel_2.e293007xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 margen_non padding_nonxxx$# style=xxx$#text-align: center;font-size: 14px;font-weight: boldxxx$# >
                        <p  class=xxx$#xxx$# >Vorname, Nachname</p>
                    </div>
                </div>
                <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div id=xxx$#p_funnel_2.3e0024xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px; margen_non padding_nonxxx$# >
                        <p  class=xxx$#xxx$# >Back-Office</p>
                    </div>
                </div>

            </div>
            <div class=xxx$# col-lg-4 col-xlg-4 col-md-4 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div id=xxx$#audio_2.0046xxx$#  class=xxx$#audio_open col-lg-12 col-xlg-12 col-md-4 text_size_bigxxx$# style=xxx$#text-align: center;xxx$# >
                        <img  src=xxx$#./images/colleagues2.pngxxx$#  alt=xxx$#xxx$# class=xxx$#border_is img-circle  logo_height_and_widthxxx$# />
                        <br>

                        <audio controls controls class=xxx$#audio-tagxxx$# type=xxx$#audio/mp3xxx$# src=xxx$#images/testing.mp3xxx$#>
                            Your browser does not support the audio element.
                        </audio>



                    </div>

                </div>

                <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div id=xxx$#p_funnel_2.30034xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 margen_non padding_nonxxx$# style=xxx$#text-align: center;font-size: 14px;font-weight: boldxxx$# >
                        <p  class=xxx$#xxx$# >Vorname, Nachname</p>
                    </div>
                </div>
                <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div id=xxx$#p_funnel_2.30e07xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px; margen_non padding_nonxxx$# >
                        <p  class=xxx$#xxx$# >Recruiter</p>
                    </div>
                </div>

            </div>
            <div class=xxx$# col-lg-4 col-xlg-4 col-md-4 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div id=xxx$#audio_2.564xxx$#  class=xxx$#audio_open col-lg-12 col-xlg-12 col-md-4 text_size_bigxxx$# style=xxx$#text-align: center;xxx$# >

                        <img  src=xxx$#./images/colleagues3.pngxxx$#  alt=xxx$#xxx$# class=xxx$#border_is img-circle  logo_height_and_widthxxx$# />
                        <br>

                        <audio controls controls class=xxx$#audio-tagxxx$# type=xxx$#audio/mp3xxx$# src=xxx$#images/testing.mp3xxx$#>
                            Your browser does not support the audio element.
                        </audio>



                    </div>

                </div>

                <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div id=xxx$#p_funnel_2.230073xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 margen_non padding_nonxxx$# style=xxx$#text-align: center;font-size: 14px;font-weight: boldxxx$# >
                        <p  class=xxx$#xxx$# >Vorname, Nachname</p>
                    </div>
                </div>
                <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div id=xxx$#p_funnel_2.43007wxxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px; margen_non padding_nonxxx$# >
                        <p  class=xxx$#xxx$# >distribution</p>
                    </div>
                </div>

            </div>





        </div>




        <div class=xxx$#drop-indicatorxxx$#></div>
    </div>
</div>


<div id=xxx$#answer-4xxx$# class=xxx$#answer mb-4 xxx$#>
    <div class=xxx$#dropzone rows-containerxxx$# id=xxx$#xxx$# ondragover=xxx$#allowDrop(event)xxx$# ondragleave=xxx$#dragLeave(event)xxx$# ondrop=xxx$#drop(event)xxx$#>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >

            <div id=xxx$#xxx$#   class=xxx$#col-lg-12 col-xlg-12 col-md-4 xxx$# >

            </div>
        </div>

        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_2.312345007xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                <p  class=xxx$#xxx$# >Multiple selection possible</p>
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_2.32290007xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 24px;xxx$# >
                <p  class=xxx$#xxx$# >What is important to you in a new job?</p>
            </div>
        </div>
        <div class=xxx$#row margen_non   draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>

            <div class=xxx$# col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#custom_container row   draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div id=xxx$#multi_selection_2.9033122xxx$# class=xxx$#multi_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>
                        <div class=xxx$#d-flex align-items-centerxxx$#>
                            <div class=xxx$#mr-2xxx$#>


                                <input class=xxx$#xxx$# type=xxx$#checkboxxxx$# value=xxx$#xxx$# id=xxx$#xxx$#> 
                            </div>
                            <div contenteditable=xxx$#truexxx$#  class=xxx$#flex-grow-1xxx$# style=xxx$#text-align: leftxxx$# >
                                <p class=xxx$#m-0xxx$#>Safe & stable workplace</p> 
                            </div>
                            <div  class=xxx$#ml-2 single_selection_iconxxx$#>
                                <i class=xxx$#fas  fa-shield-altxxx$#></i> 
                            </div>
                        </div>


                    </div>
                </div>

            </div>


            <div class=xxx$# col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#custom_container row   draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div id=xxx$#multi_selection_2.9033211xxx$# class=xxx$#multi_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>
                        <div class=xxx$#d-flex align-items-centerxxx$#>
                            <div class=xxx$#mr-2 pl-2xxx$#>
                                <input class=xxx$#xxx$# type=xxx$#checkboxxxx$# value=xxx$#xxx$# id=xxx$#xxx$#> 
                            </div>
                            <div contenteditable=xxx$#truexxx$#  class=xxx$#flex-grow-1xxx$# style=xxx$#text-align: leftxxx$# >
                                <p class=xxx$#m-0xxx$#>Safe & stable workplace</p> <!-- Text Element -->
                            </div>
                            <div  class=xxx$#ml-2 single_selection_iconxxx$#>
                                <i class=xxx$#fas  fa-clock xxx$#></i> 
                            </div>
                        </div>


                    </div>
                </div>

            </div>

            <div class=xxx$# col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#custom_container row   draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div id=xxx$#multi_selection_2.90332xxx$# class=xxx$#multi_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>
                        <div class=xxx$#d-flex align-items-centerxxx$#>
                            <div class=xxx$#mr-2 pl-2xxx$#>
                                <input class=xxx$#xxx$# type=xxx$#checkboxxxx$# value=xxx$#xxx$# id=xxx$#xxx$#> 
                            </div>
                            <div contenteditable=xxx$#truexxx$#  class=xxx$#flex-grow-1xxx$# style=xxx$#text-align: leftxxx$# >
                                <p class=xxx$#m-0xxx$#>continuing education</p> <!-- Text Element -->
                            </div>
                            <div  class=xxx$#ml-2 single_selection_iconxxx$#>
                                <i class=xxx$#fas  fa-clock xxx$#></i> 
                            </div>
                        </div>


                    </div>
                </div>

            </div>
            <div class=xxx$# col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#custom_container row   draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div id=xxx$#multi_selection_2.9033213xxx$# class=xxx$#multi_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>
                        <div class=xxx$#d-flex align-items-centerxxx$#>
                            <div class=xxx$#mr-2 pl-2xxx$#>
                                <input class=xxx$#xxx$# type=xxx$#checkboxxxx$# value=xxx$#xxx$# id=xxx$#xxx$#> 
                            </div>
                            <div contenteditable=xxx$#truexxx$#  class=xxx$#flex-grow-1xxx$# style=xxx$#text-align: leftxxx$# >
                                <p class=xxx$#m-0xxx$#>Creative unfolding</p> <!-- Text Element -->
                            </div>
                            <div  class=xxx$#ml-2 single_selection_iconxxx$#>
                                <i class=xxx$#fas  fa-broom xxx$#></i> 
                            </div>
                        </div>


                    </div>
                </div>

            </div>

            <div id=xxx$#single_plus_id_3xxx$# class=xxx$#multi_plus col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >

                <div class=xxx$# row xxx$#   >

                    <div id=xxx$#multi_selection.90333xxx$# class=xxx$#   margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>

                        <div class=xxx$#custom-column_add xxx$#>
                            <i class=xxx$#fas fa-2x fa-plusxxx$#></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#btn_432.0xxx$# class=xxx$#open_button col-lg-12 col-xlg-12 col-md-12 xxx$# style=xxx$#text-align: center;xxx$#> 
                <a onclick=xxx$#showAnswer_20(xxxn4$#5xxxn4$#)xxx$# href=xxx$##xxx$# contenteditable=xxx$#truexxx$# class=xxx$#btn btn-info btn-rounded waves-effect waves-light xxx$#>To the next question </a>

            </div>
        </div>
        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$# >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_2.300011xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open margen_non padding_non col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;center;font-size: 14px;xxx$# >
                <p  class=xxx$#padding_non margen_nonxxx$#  >💡 Did you know that we regularly receive feedback and that employees fulfill their wishes?</p>
            </div>
        </div>
        <div class=xxx$#drop-indicatorxxx$#></div>
    </div>
</div>



<div id=xxx$#answer-5xxx$# class=xxx$#answer mb-4 xxx$#>
    <div class=xxx$#dropzone rows-containerxxx$# id=xxx$#xxx$# ondragover=xxx$#allowDrop(event)xxx$# ondragleave=xxx$#dragLeave(event)xxx$# ondrop=xxx$#drop(event)xxx$#>
        <!--                                            //logo-->
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >

            <div id=xxx$#xxx$#   class=xxx$#col-lg-12 col-xlg-12 col-md-4 xxx$# >

            </div>
        </div>

        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_2.3007q323xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 24px;xxx$# >
                <p  class=xxx$#xxx$# >How many years of work experience do you have?</p>
            </div>
        </div>
        <div class=xxx$#row margen_non   draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>

            <div class=xxx$# col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#custom_container row   draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div onclick=xxx$#showAnswer_20(xxxn4$#6xxxn4$#)xxx$# id=xxx$#single.503311xxx$# class=xxx$#single_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>
                        <div class=xxx$#d-flex align-items-centerxxx$#>
                            <div class=xxx$#mr-2xxx$#>
                                <i class=xxx$#fas fa-2x fa-angle-rightxxx$#></i> <!-- Small Icon -->
                            </div>
                            <div contenteditable=xxx$#truexxx$#  class=xxx$#flex-grow-1xxx$# style=xxx$#text-align: leftxxx$# >
                                <p class=xxx$#m-0xxx$#><  1 year</p> <!-- Text Element -->
                            </div>
                            <div  class=xxx$#ml-2 single_selection_iconxxx$#>
                                <i class=xxx$#fas  fa-seedlingxxx$#></i> <!-- Big Icon -->
                            </div>
                        </div>


                    </div>
                </div>

            </div>


            <div class=xxx$# col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#custom_container row   draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div  class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div onclick=xxx$#showAnswer_20(xxxn4$#6xxxn4$#)xxx$# id=xxx$#single_5.5033233xxx$# class=xxx$#single_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>
                        <div class=xxx$#d-flex align-items-centerxxx$#>
                            <div class=xxx$#mr-2xxx$#>
                                <i class=xxx$#fas fa-2x fa-angle-rightxxx$#></i> <!-- Small Icon -->
                            </div>
                            <div contenteditable=xxx$#truexxx$#  class=xxx$#flex-grow-1xxx$# style=xxx$#text-align: leftxxx$# >
                                <p class=xxx$#m-0xxx$#>1-5 years</p> <!-- Text Element -->
                            </div>
                            <div  class=xxx$#ml-2 single_selection_iconxxx$#>
                                <i class=xxx$#fas  fa-briefcase xxx$#></i> <!-- Big Icon -->
                            </div>
                        </div>


                    </div>
                </div>

            </div>


            <div class=xxx$# col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#custom_container row   draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div onclick=xxx$#showAnswer_20(xxxn4$#6xxxn4$#)xxx$# id=xxx$#single_5.50332334xxx$# class=xxx$#single_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>
                        <div class=xxx$#d-flex align-items-centerxxx$#>
                            <div class=xxx$#mr-2xxx$#>
                                <i class=xxx$#fas fa-2x fa-angle-rightxxx$#></i> <!-- Small Icon -->
                            </div>
                            <div contenteditable=xxx$#truexxx$#  class=xxx$#flex-grow-1xxx$# style=xxx$#text-align: leftxxx$# >
                                <p class=xxx$#m-0xxx$#>6-10 years</p> <!-- Text Element -->
                            </div>
                            <div  class=xxx$#ml-2 single_selection_iconxxx$#>
                                <i class=xxx$#fas  fa-business-time xxx$#></i> <!-- Big Icon -->
                            </div>
                        </div>


                    </div>
                </div>

            </div>
            <div class=xxx$# col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#custom_container row   draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div onclick=xxx$#showAnswer_20(xxxn4$#6xxxn4$#)xxx$# id=xxx$#single_5.50332355xxx$# class=xxx$#single_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>
                        <div class=xxx$#d-flex align-items-centerxxx$#>
                            <div class=xxx$#mr-2xxx$#>
                                <i class=xxx$#fas fa-2x fa-angle-rightxxx$#></i> <!-- Small Icon -->
                            </div>
                            <div contenteditable=xxx$#truexxx$#  class=xxx$#flex-grow-1xxx$# style=xxx$#text-align: leftxxx$# >
                                <p class=xxx$#m-0xxx$#>10+ years</p> <!-- Text Element -->
                            </div>
                            <div  class=xxx$#ml-2 single_selection_iconxxx$#>
                                <i class=xxx$#fas  fa-arrow-alt-circle-up xxx$#></i> <!-- Big Icon -->
                            </div>
                        </div>


                    </div>
                </div>

            </div>

            <div id=xxx$#single_plus_id_3xxx$# class=xxx$#single_plus col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >

                <div class=xxx$# row xxx$#   >

                    <div id=xxx$#single_5.90333xxx$# class=xxx$#   margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>

                        <div class=xxx$#custom-column_add xxx$#>
                            <i class=xxx$#fas fa-2x fa-plusxxx$#></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>










        <div class=xxx$#drop-indicatorxxx$#></div>
    </div>
</div>

<div id=xxx$#answer-6xxx$# class=xxx$#answer mb-4 xxx$#>
    <div class=xxx$#dropzone rows-containerxxx$# id=xxx$#xxx$# ondragover=xxx$#allowDrop(event)xxx$# ondragleave=xxx$#dragLeave(event)xxx$# ondrop=xxx$#drop(event)xxx$#>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >

            <div id=xxx$#xxx$#   class=xxx$#col-lg-12 col-xlg-12 col-md-4 xxx$# >

            </div>
        </div>
        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#audio_2.56420xxx$#  class=xxx$#audio_open col-lg-12 col-xlg-12 col-md-4 text_size_bigxxx$# style=xxx$#text-align: center;xxx$# >

                <img  src=xxx$#./images/colleagues3.pngxxx$#  alt=xxx$#xxx$# class=xxx$#border_is img-circle  logo_height_and_widthxxx$# />
                <br>

                <audio controls controls class=xxx$#audio-tagxxx$# type=xxx$#audio/mp3xxx$# src=xxx$#images/testing.mp3xxx$#>
                    Your browser does not support the audio element.
                </audio>
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_6.1300720xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                <p  class=xxx$#xxx$# >⚡ Done it:</p>
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_6.630071xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 24px;xxx$# >
                <p  class=xxx$#xxx$# >Describe yourself in three or four short sentences?</p>
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_6.63007xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#textarea_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                <textarea style=xxx$#min-width: 200px; max-width: 600px;xxx$# class=xxx$#form-controlxxx$# placeholder=xxx$#What are you currently doing?  Where are your skills and strengths?xxx$# id=xxx$#xxx$# name=xxx$#xxx$# rows=xxx$#6xxx$# cols=xxx$#100xxx$#></textarea>
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#btn_6.0xxx$# class=xxx$#open_button col-lg-12 col-xlg-12 col-md-12 xxx$# style=xxx$#text-align: center;xxx$#> 
                <a onclick=xxx$#showAnswer_20(xxxn4$#7xxxn4$#)xxx$# href=xxx$##xxx$# contenteditable=xxx$#truexxx$# class=xxx$#btn btn-info btn-rounded waves-effect waves-light xxx$#>To the next question </a>

            </div>
        </div>

        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div  class=xxx$#col-lg-12 col-xlg-12 col-md-4 text-centerxxx$#>
                <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#col-lg-4 col-xlg-4 col-md-4 text-center xxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$# >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_6.22000xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open margen_non padding_non col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;center;font-size: 35px;font-weight: boldxxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$#  >50+👥 </p>
                            </div>
                        </div>

                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_6.2220xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open padding_non col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 17px;xxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$# >Employees</p>
                            </div>
                        </div>


                    </div>
                    <div class=xxx$#col-lg-4 col-xlg-4 col-md-4 text-center xxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$# >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_6.30001xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open margen_non padding_non col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;center;font-size: 35px;font-weight: boldxxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$#  >~10🎳 </p>
                            </div>
                        </div>

                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_6.30023xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open padding_non col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 17px;xxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$# >team events per year</p>
                            </div>
                        </div>


                    </div>
                    <div class=xxx$#col-lg-4 col-xlg-4 col-md-4 text-center xxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$# >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_6.200134xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open margen_non padding_non col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;font-size: 40px;font-weight: boldxxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$#  >100%🤝</p>
                            </div>
                        </div>

                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_6.39380xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open padding_non col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 17px;xxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$# >Solidarity since 1996</p>
                            </div>
                        </div>


                    </div>

                </div>
            </div>

        </div>








        <div class=xxx$#drop-indicatorxxx$#></div>
    </div>
</div>



<div id=xxx$#answer-7xxx$# class=xxx$#answer mb-4 xxx$#>
    <div class=xxx$#dropzone rows-containerxxx$# id=xxx$#xxx$# ondragover=xxx$#allowDrop(event)xxx$# ondragleave=xxx$#dragLeave(event)xxx$# ondrop=xxx$#drop(event)xxx$#>

        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >

            <div id=xxx$#xxx$#   class=xxx$#col-lg-12 col-xlg-12 col-md-4 xxx$# >

            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_7.3007xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 24px;xxx$# >
                <p  class=xxx$#xxx$# >When could you start with us?</p>
            </div>
        </div>
        <div class=xxx$#row margen_non   draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>

            <div class=xxx$# col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#custom_container row   draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div onclick=xxx$#showAnswer_20(xxxn4$#8xxxn4$#)xxx$# id=xxx$#single.703311xxx$# class=xxx$#single_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>
                        <div class=xxx$#d-flex align-items-centerxxx$#>
                            <div class=xxx$#mr-2xxx$#>
                                <i class=xxx$#fas fa-2x fa-angle-rightxxx$#></i> <!-- Small Icon -->
                            </div>
                            <div contenteditable=xxx$#truexxx$#  class=xxx$#flex-grow-1xxx$# style=xxx$#text-align: leftxxx$# >
                                <p class=xxx$#m-0xxx$#>At any time</p> <!-- Text Element -->
                            </div>
                            <div  class=xxx$#ml-2 single_selection_iconxxx$#>
                                <i class=xxx$#fas  fa-rocketxxx$#></i> <!-- Big Icon -->
                            </div>
                        </div>


                    </div>
                </div>

            </div>


            <div class=xxx$# col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#custom_container row   draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div onclick=xxx$#showAnswer_20(xxxn4$#8xxxn4$#)xxx$# id=xxx$#single_7.5033233xxx$# class=xxx$#single_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>
                        <div class=xxx$#d-flex align-items-centerxxx$#>
                            <div class=xxx$#mr-2xxx$#>
                                <i class=xxx$#fas fa-2x fa-angle-rightxxx$#></i> <!-- Small Icon -->
                            </div>
                            <div contenteditable=xxx$#truexxx$#  class=xxx$#flex-grow-1xxx$# style=xxx$#text-align: leftxxx$# >
                                <p class=xxx$#m-0xxx$#>In 2-3 weeks</p> <!-- Text Element -->
                            </div>
                            <div  class=xxx$#ml-2 single_selection_iconxxx$#>
                                <i class=xxx$#fas  fa-user-clock xxx$#></i> <!-- Big Icon -->
                            </div>
                        </div>


                    </div>
                </div>

            </div>


            <div class=xxx$# col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#custom_container row   draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div onclick=xxx$#showAnswer_20(xxxn4$#8xxxn4$#)xxx$# id=xxx$#single_7.50332334xxx$# class=xxx$#single_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>
                        <div class=xxx$#d-flex align-items-centerxxx$#>
                            <div class=xxx$#mr-2xxx$#>
                                <i class=xxx$#fas fa-2x fa-angle-rightxxx$#></i> <!-- Small Icon -->
                            </div>
                            <div contenteditable=xxx$#truexxx$#  class=xxx$#flex-grow-1xxx$# style=xxx$#text-align: leftxxx$# >
                                <p class=xxx$#m-0xxx$#>1-2 months</p> <!-- Text Element -->
                            </div>
                            <div  class=xxx$#ml-2 single_selection_iconxxx$#>
                                <i class=xxx$#fas  fa-calendar xxx$#></i> <!-- Big Icon -->
                            </div>
                        </div>


                    </div>
                </div>

            </div>
            <div class=xxx$# col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#custom_container row   draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div onclick=xxx$#showAnswer_20(xxxn4$#8xxxn4$#)xxx$# id=xxx$#single_7.50332355xxx$# class=xxx$#single_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>
                        <div class=xxx$#d-flex align-items-centerxxx$#>
                            <div class=xxx$#mr-2xxx$#>
                                <i class=xxx$#fas fa-2x fa-angle-rightxxx$#></i> <!-- Small Icon -->
                            </div>
                            <div contenteditable=xxx$#truexxx$#  class=xxx$#flex-grow-1xxx$# style=xxx$#text-align: leftxxx$# >
                                <p class=xxx$#m-0xxx$#>2+ months</p> <!-- Text Element -->
                            </div>
                            <div  class=xxx$#ml-2 single_selection_iconxxx$#>
                                <i class=xxx$#fas  fa-clock xxx$#></i> <!-- Big Icon -->
                            </div>
                        </div>


                    </div>
                </div>

            </div>

            <div id=xxx$#single_plus_id_7xxx$# class=xxx$#single_plus col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >

                <div class=xxx$# row xxx$#   >

                    <div id=xxx$#single_7.90333xxx$# class=xxx$#   margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>

                        <div class=xxx$#custom-column_add xxx$#>
                            <i class=xxx$#fas fa-2x fa-plusxxx$#></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_7.132007xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                <p  class=xxx$#xxx$# >Get started immediately</p>
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_6.13007xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 40px;font-weight: bold;xxx$# >
                <p  class=xxx$#xxx$# >Your effective induction program</p>
            </div>
        </div>

        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div  class=xxx$#col-lg-12 col-xlg-12 col-md-4 text-centerxxx$#>
                <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#col-lg-6 col-xlg-6 col-md-6 text-center xxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#icon_7.1xxx$# class=xxx$#icon_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 35px;xxx$# >
                                <i class=xxx$#fas fa-user-plusxxx$#></i>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#p_funnel_7.002s2xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4   xxx$# style=xxx$#text-align: center;font-size: 17px;font-weight: boldxxx$# >
                                <p > Contact person</p>
                            </div>
                        </div>

                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_7.e1004xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$#>
                                <p>Every new employee is quickly assigned a contact person who is available for questions and support.</p>
                            </div>
                        </div>

                    </div>
                    <div class=xxx$#col-lg-6 col-xlg-6 col-md-6 text-centerxxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#icon_7.029xxx$# class=xxx$#icon_open col-lg-12 col-xlg-12 col-md-4  xxx$# style=xxx$#text-align: center;font-size: 35px;xxx$# >
                                <i class=xxx$#fas fa-videoxxx$#></i>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_1347.3389xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4  bold_text text_size_minimumxxx$# style=xxx$#text-align: center;font-size: 17px;font-weight: boldxxx$# >
                                <p >Digital training portal</p>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_1eq.923exxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                                <p>Access to an extensive video training portal for internal processes and procedures.</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>


        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div  class=xxx$#col-lg-12 col-xlg-12 col-md-4 text-centerxxx$#>
                <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#col-lg-6 col-xlg-6 col-md-6 text-center xxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#icon_7,3404xxx$# class=xxx$#icon_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 35px;xxx$# >
                                <i class=xxx$#fas fa-commentsxxx$#></i>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#p_funnel_7.3443xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4   xxx$# style=xxx$#text-align: center;font-size: 17px;font-weight: boldxxx$# >
                                <p > Regular feedback talks</p>
                            </div>
                        </div>

                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_7.483894xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$#>
                                <p>Monthly feedback is received from employees so that we can develop together. Nothing goes unheard.</p>
                            </div>
                        </div>

                    </div>


                    <div class=xxx$#col-lg-6 col-xlg-6 col-md-6 text-centerxxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#icon_7.09349xxx$# class=xxx$#icon_open col-lg-12 col-xlg-12 col-md-4  xxx$# style=xxx$#text-align: center;font-size: 35px;xxx$# >
                                <i class=xxx$#fas fa-shipping-fastxxx$#></i>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_1237.3e23823xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4  bold_text text_size_minimumxxx$# style=xxx$#text-align: center;font-size: 17px;font-weight: boldxxx$# >
                                <p > Quick to use</p>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2337.9934xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                                <p>Thanks to our digital training portal and processes, you will be ready for action in no time at all, without any question marks in your head.</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>





        <div class=xxx$#drop-indicatorxxx$#></div>
    </div>
</div>

<div id=xxx$#answer-8xxx$# class=xxx$#answer mb-4 xxx$#>
    <div class=xxx$#dropzone rows-containerxxx$# id=xxx$#xxx$# ondragover=xxx$#allowDrop(event)xxx$# ondragleave=xxx$#dragLeave(event)xxx$# ondrop=xxx$#drop(event)xxx$#>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >

            <div id=xxx$#xxx$#   class=xxx$#col-lg-12 col-xlg-12 col-md-4 xxx$# >

            </div>
        </div>

        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_7.300723561xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 24px;xxx$# >
                <p  class=xxx$#xxx$# >Upload CV now </p>
            </div>
        </div>

        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_upload_7.3007123dsqxxx$# contenteditable=xxx$#truexxx$#  class=xxx$#cv_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 24px;xxx$# >
                <div class=xxx$#custom-file-containerxxx$#>
                    <div class=xxx$#solid-borderxxx$#>
                        <div class=xxx$#dotted-borderxxx$# id=xxx$#dottedContainerxxx$#>
                            <input type=xxx$#filexxx$# id=xxx$#cv_idxxx$# style=xxx$#display: none;xxx$#>
                            <div class=xxx$#upload-iconxxx$#>
                                <i class=xxx$#fas fa-cloud-upload-altxxx$#></i>
                            </div>
                            <div class=xxx$#upload-textxxx$# id=xxx$#uploadTextxxx$#>
                                Click or drop a file here
                            </div>
                            <div class=xxx$#remove-file-linkxxx$# id=xxx$#removeFileLinkxxx$# style=xxx$#display: none;xxx$#>Remove</div>
                        </div>
                    </div>
                </div>
                <a onclick=xxx$#showAnswer_20(xxxn4$#9xxxn4$#)xxx$# href=xxx$##xxx$# contenteditable=xxx$#truexxx$# class=xxx$#btn btn-info btn-rounded waves-effect waves-light mt-4xxx$#>Send</a>


                <br>
                <p onclick = xxx$#showAnswer_20(xxxn4$#9xxxn4$#,xxxn4$#skipxxxn4$#)xxx$# class=xxx$#mt-4 skip_pxxx$#  >Skip</p>

                <div class=xxx$#message mt-3xxx$#>Please select a file.</div>
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_7.300711134xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                <p  class=xxx$#xxx$# >  🔒 diskret & sicher gespeichert - nur für interne Bewerbungsprozesse </p>
            </div>
        </div>



        <div class=xxx$#drop-indicatorxxx$#></div>
    </div>
</div>



<div id=xxx$#answer-9xxx$# class=xxx$#answer mb-4 xxx$#>
    <div class=xxx$#dropzone rows-containerxxx$# id=xxx$#xxx$# ondragover=xxx$#allowDrop(event)xxx$# ondragleave=xxx$#dragLeave(event)xxx$# ondrop=xxx$#drop(event)xxx$#>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >

            <div id=xxx$#xxx$#   class=xxx$#col-lg-12 col-xlg-12 col-md-4 xxx$# >

            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_17.113007xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                <p  class=xxx$#xxx$# >✔️ Done... Now just choose the time & leave contact.</p>
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_1273.3007xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 24px;xxx$# >
                <p  class=xxx$#xxx$# >When is the earliest we can reach you?</p>
            </div>
        </div>
        <div class=xxx$#row margen_non   draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>

            <div class=xxx$# col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#custom_container row   draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div onclick=xxx$#showAnswer_20(xxxn4$#10xxxn4$#)xxx$# id=xxx$#single3.75503311xxx$# class=xxx$#single_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>
                        <div class=xxx$#d-flex align-items-centerxxx$#>
                            <div class=xxx$#mr-2xxx$#>
                                <i class=xxx$#fas fa-2x fa-angle-rightxxx$#></i> <!-- Small Icon -->
                            </div>
                            <div contenteditable=xxx$#truexxx$#  class=xxx$#flex-grow-1xxx$# style=xxx$#text-align: leftxxx$# >
                                <p class=xxx$#m-0xxx$#>10-12 a.m</p> <!-- Text Element -->
                            </div>
                            <div  class=xxx$#ml-2 single_selection_iconxxx$#>
                                <i class=xxx$#fas  fa-clockxxx$#></i> <!-- Big Icon -->
                            </div>
                        </div>


                    </div>
                </div>

            </div>


            <div class=xxx$# col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#custom_container row   draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div onclick=xxx$#showAnswer_20(xxxn4$#10xxxn4$#)xxx$# id=xxx$#single_7q.5033288833xxx$# class=xxx$#single_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>
                        <div class=xxx$#d-flex align-items-centerxxx$#>
                            <div class=xxx$#mr-2xxx$#>
                                <i class=xxx$#fas fa-2x fa-angle-rightxxx$#></i> <!-- Small Icon -->
                            </div>
                            <div contenteditable=xxx$#truexxx$#  class=xxx$#flex-grow-1xxx$# style=xxx$#text-align: leftxxx$# >
                                <p class=xxx$#m-0xxx$#>12pm-2pm</p> <!-- Text Element -->
                            </div>
                            <div  class=xxx$#ml-2 single_selection_iconxxx$#>
                                <i class=xxx$#fas  fa-clock xxx$#></i> <!-- Big Icon -->
                            </div>
                        </div>


                    </div>
                </div>

            </div>


            <div class=xxx$# col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#custom_container row   draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div onclick=xxx$#showAnswer_20(xxxn4$#10xxxn4$#)xxx$# id=xxx$#single_7.6650332334xxx$# class=xxx$#single_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>
                        <div class=xxx$#d-flex align-items-centerxxx$#>
                            <div class=xxx$#mr-2xxx$#>
                                <i class=xxx$#fas fa-2x fa-angle-rightxxx$#></i> <!-- Small Icon -->
                            </div>
                            <div contenteditable=xxx$#truexxx$#  class=xxx$#flex-grow-1xxx$# style=xxx$#text-align: leftxxx$# >
                                <p class=xxx$#m-0xxx$#>2-4 p.m</p> <!-- Text Element -->
                            </div>
                            <div  class=xxx$#ml-2 single_selection_iconxxx$#>
                                <i class=xxx$#fas  fa-clock xxx$#></i> <!-- Big Icon -->
                            </div>
                        </div>


                    </div>
                </div>

            </div>
            <div class=xxx$# col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >
                <div class=xxx$#custom_container row   draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                    <div onclick=xxx$#showAnswer_20(xxxn4$#10xxxn4$#)xxx$# id=xxx$#single_7.5066332355xxx$# class=xxx$#single_selection_open custom_column margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>
                        <div class=xxx$#d-flex align-items-centerxxx$#>
                            <div class=xxx$#mr-2xxx$#>
                                <i class=xxx$#fas fa-2x fa-angle-rightxxx$#></i> <!-- Small Icon -->
                            </div>
                            <div contenteditable=xxx$#truexxx$#  class=xxx$#flex-grow-1xxx$# style=xxx$#text-align: leftxxx$# >
                                <p class=xxx$#m-0xxx$#>4-6 p.m</p> <!-- Text Element -->
                            </div>
                            <div  class=xxx$#ml-2 single_selection_iconxxx$#>
                                <i class=xxx$#fas  fa-clock xxx$#></i> <!-- Big Icon -->
                            </div>
                        </div>


                    </div>
                </div>

            </div>

            <div id=xxx$#single_plus_id_7xxx$# class=xxx$#single_plus col-lg-6 col-xlg-6 col-md-6 text-center padding_non margen_nonxxx$# draggable=xxx$#truexxx$#  >

                <div class=xxx$# row xxx$#   >

                    <div id=xxx$#single_7892389.90333xxx$# class=xxx$#   margen_non   col-lg-12 col-xlg-12 col-md-12  xxx$#>

                        <div class=xxx$#custom-column_add xxx$#>
                            <i class=xxx$#fas fa-2x fa-plusxxx$#></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>











        <div class=xxx$#drop-indicatorxxx$#></div>
    </div>
</div>



<div id=xxx$#answer-10xxx$# class=xxx$#answer mb-4 xxx$#>
    <div class=xxx$#dropzone rows-containerxxx$# id=xxx$#xxx$# ondragover=xxx$#allowDrop(event)xxx$# ondragleave=xxx$#dragLeave(event)xxx$# ondrop=xxx$#drop(event)xxx$#>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >

            <div id=xxx$#xxx$#   class=xxx$#col-lg-12 col-xlg-12 col-md-4 xxx$# >

            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#audio_12000xxx$#  class=xxx$#audio_open col-lg-12 col-xlg-12 col-md-4 text_size_bigxxx$# style=xxx$#text-align: center;xxx$# >
                <img  src=xxx$#./assets/images/colleagues3.pngxxx$#  alt=xxx$#xxx$# class=xxx$#border_is img-circle  logo_height_and_widthxxx$# />
                <br>

                <audio controls controls class=xxx$#audio-tagxxx$# type=xxx$#audio/mp3xxx$# src=xxx$#images/testing.mp3xxx$#>
                    Your browser does not support the audio element.
                </audio>



            </div>

        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_121273.3007xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 24px;xxx$# >
                <p  class=xxx$#xxx$# >Your contact person: first name last name</p>
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_1273.3021107xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                <p  class=xxx$#xxx$# >I will personally process your application and look forward to meeting you soon!</p>
            </div>
        </div>

        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_qqq1273.30211d07xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#form_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;xxx$# >
                <div class=xxx$#input-group mb-3 xxx$#>
                    <div class=xxx$#input-group-prependxxx$#>
                        <span class=xxx$#input-group-textxxx$#>
                            <i class=xxx$#fas fa-userxxx$#></i>
                        </span>
                    </div>
                    <input type=xxx$#textxxx$# class=xxx$#form-control input-lg xxx$# placeholder=xxx$#Usernamexxx$#>
                </div>
                <div class=xxx$#input-group mb-3 xxx$#>
                    <div class=xxx$#input-group-prependxxx$#>
                        <span class=xxx$#input-group-textxxx$#>
                            <i class=xxx$#fas fa-envelopexxx$#></i>
                        </span>
                    </div>
                    <input type=xxx$#emailxxx$# class=xxx$#form-control  input-lg xxx$# placeholder=xxx$#Emailxxx$#>
                </div>

                <div class=xxx$#input-group mb-3 xxx$#>
                    <div class=xxx$#input-group-prependxxx$#>
                        <span class=xxx$#input-group-textxxx$#>
                            <i class=xxx$#fas fa-flagxxx$#></i>
                        </span>
                    </div>
                    <input type=xxx$#numberxxx$# class=xxx$#form-control input-lg xxx$# placeholder=xxx$#Phone Numberxxx$#>
                </div>
                <div class=xxx$#checkbox checkbox-success xxx$#>
                    <input  required id=xxx$#submit_required2111xxx$# type=xxx$#checkboxxxx$#>
                    <label class=xxx$#d-inlinexxx$# for=xxx$#submit_required2111xxx$#> I agree to the   
                        <a class=xxx$#color_isxxx$#  onclick=xxx$#event_privacy()xxx$# href=xxx$#JavaScript:void(0);xxx$# ><u>
                            privacy policy </u></a> of First Name Last Name and allow me to contact you.</label>
                </div>
                <a onclick=xxx$#showAnswer_20(xxxn4$#thanksxxxn4$#)xxx$# href=xxx$##xxx$# contenteditable=xxx$#truexxx$# class=xxx$#btn btn-info btn-rounded waves-effect waves-light mt-4xxx$#>I want to get to know you </a>

            </div>
        </div>


        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div  class=xxx$#col-lg-12 col-xlg-12 col-md-4 text-centerxxx$#>
                <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#col-lg-4 col-xlg-4 col-md-4 text-center xxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$# >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.220002233xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open margen_non padding_non col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;center;font-size: 40px;font-weight: boldxxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$#  >1.</p>
                            </div>
                        </div>

                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.223323220xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open padding_non col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 17px;xxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$# >Enter data</p>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$# >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.2433432223xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open margen_non padding_non col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;center;font-size: 10px;xxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$#  >Enter your contact details. They will only be used for the application</p>
                            </div>
                        </div>

                    </div>
                    <div class=xxx$#col-lg-4 col-xlg-4 col-md-4 text-center xxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$# >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.33434410001xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open margen_non padding_non col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;center;font-size: 40px;font-weight: boldxxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$#  >2.</p>
                            </div>
                        </div>

                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.323233210023xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open padding_non col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 17px;xxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$# >Telephone contact</p>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$# >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.223232313340xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open margen_non padding_non col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;center;font-size: 10px;xxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$#  >We will evaluate your answers and get back to you</p>
                            </div>
                        </div>

                    </div>
                    <div class=xxx$#col-lg-4 col-xlg-4 col-md-4 text-center xxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$# >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.20223232310134xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open margen_non padding_non col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;font-size: 40px;font-weight: boldxxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$#  >3.</p>
                            </div>
                        </div>

                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.392323231380xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open padding_non col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 17px;xxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$# >You have your dream job</p>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non padding_non  draggablexxx$# draggable=xxx$#truexxx$# >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_2.78eewewe1327221xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open margen_non padding_non col-lg-12 col-xlg-12 col-md-12 xxx$#  style=xxx$#text-align: center;center;font-size: 10px;xxx$# >
                                <p  class=xxx$#padding_non margen_nonxxx$#  >If everything fits, we look forward to welcoming you to the team soon</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>









        <div class=xxx$#drop-indicatorxxx$#></div>
    </div>
</div>

<div id=xxx$#thanksxxx$# class=xxx$#answer mb-4 xxx$#>
    <div class=xxx$#dropzone rows-containerxxx$# id=xxx$#xxx$# ondragover=xxx$#allowDrop(event)xxx$# ondragleave=xxx$#dragLeave(event)xxx$# ondrop=xxx$#drop(event)xxx$#>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >

            <div id=xxx$#xxx$#   class=xxx$#col-lg-12 col-xlg-12 col-md-4 xxx$# >

            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div  id=xxx$#icon_922442.09349xxx$# class=xxx$#icon_open col-lg-12 col-xlg-12 col-md-4  xxx$# style=xxx$#text-align: center;font-size: 70px;xxx$# >
                <i class=xxx$#fas fa-check-doublexxx$#></i>
            </div>
        </div>


        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_1127.3007122xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 30px;xxx$# >
                <p  class=xxx$#xxx$# >Your application has reached us!</p>
            </div>
        </div>


        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#image_1qq1xxx$# class=xxx$# open_image col-lg-12 col-xlg-12 col-md-12  xxx$# style=xxx$#text-align: center;xxx$#>
                <img src=xxx$#./images/thanks.pngxxx$#  alt=xxx$#xxx$# class=xxx$#dark-logo logo_padding fit_to_divxxx$# />
            </div>
        </div>


        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div  class=xxx$#col-lg-12 col-xlg-12 col-md-4 text-centerxxx$#>
                <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                    <div class=xxx$#col-lg-4 col-xlg-4 col-md-4 text-center xxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#icon_72323,3404xxx$# class=xxx$#icon_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 35px;xxx$# >
                                <i class=xxx$#fas fa-searchxxx$#></i>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#p_funnel_7233.3443xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4   xxx$# style=xxx$#text-align: center;font-size: 17px;font-weight: boldxxx$# >
                                <p >1. Review</p>
                            </div>
                        </div>

                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_7223.483894xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$#>
                                <p>We review your application.</p>
                            </div>
                        </div>

                    </div>


                    <div class=xxx$#col-lg-4 col-xlg-4 col-md-4 text-centerxxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#icon_74331.09349xxx$# class=xxx$#icon_open col-lg-12 col-xlg-12 col-md-4  xxx$# style=xxx$#text-align: center;font-size: 35px;xxx$# >
                                <i class=xxx$#fas fa-phone-altxxx$#></i>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_7345.323823xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4  bold_text text_size_minimumxxx$# style=xxx$#text-align: center;font-size: 17px;font-weight: boldxxx$# >
                                <p >2. Contact</p>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_712.9934xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                                <p>We will contact you within the next 48 hours. If everything fits, you will receive suggestions for the interview.</p>
                            </div>
                        </div>

                    </div>
                    <div class=xxx$#col-lg-4 col-xlg-4 col-md-4 text-centerxxx$# draggable=xxx$#truexxx$#  >


                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div  id=xxx$#icon_7.09349xxx$# class=xxx$#icon_open col-lg-12 col-xlg-12 col-md-4  xxx$# style=xxx$#text-align: center;font-size: 35px;xxx$# >
                                <i class=xxx$#fas fa-hands-helpingxxx$#></i>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_133.323381823xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4  bold_text text_size_minimumxxx$# style=xxx$#text-align: center;font-size: 17px;font-weight: boldxxx$# >
                                <p > 3. New dream job</p>
                            </div>
                        </div>
                        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
                            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
                            <div id=xxx$#p_funnel_7.99341743t3xxx$# contenteditable=xxx$#truexxx$# class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 14px;xxx$# >
                                <p>We look forward to welcoming you to the team soon</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>





        <div class=xxx$#drop-indicatorxxx$#></div>
    </div>
</div>
<div id=xxx$#disqualificationxxx$# class=xxx$#answer mb-4 xxx$#>
    <div class=xxx$#dropzone rows-containerxxx$# id=xxx$#xxx$# ondragover=xxx$#allowDrop(event)xxx$# ondragleave=xxx$#dragLeave(event)xxx$# ondrop=xxx$#drop(event)xxx$#>

        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >

            <div id=xxx$#xxx$#   class=xxx$#col-lg-12 col-xlg-12 col-md-4 xxx$# >

            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div  id=xxx$#icon_9.093490128923xxx$# class=xxx$#icon_open col-lg-12 col-xlg-12 col-md-4  xxx$# style=xxx$#text-align: center;font-size: 70px;xxx$# >
                <i class=xxx$#fas fa-times-circlexxx$#></i>
            </div>
        </div>


        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_7.300778237237xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size: 30px;xxx$# >
                <p  class=xxx$#xxx$# >Too bad that doesnxxxn4$#t fit 😔</p>
            </div>
        </div>

        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_7.3007124172xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size:14px;xxx$# >
                <p  class=xxx$#xxx$# >Unfortunately, we have certain requirements for [job title].But maybe you know someone who might be interested in the job?</p>
            </div>
        </div>
        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#p_funnel_7.300713112xxx$# contenteditable=xxx$#truexxx$#  class=xxx$#text_open col-lg-12 col-xlg-12 col-md-4 xxx$# style=xxx$#text-align: center;font-size:14px;;font-weight: boldxxx$# >
                <p  class=xxx$#xxx$# >1. open link, 2. copy, 3. send to friend</p>
            </div>
        </div>

        <div class=xxx$#row margen_non  draggablexxx$# draggable=xxx$#truexxx$#  >
            <div class=xxx$#delete-buttonxxx$# onclick=xxx$#deleteRow(this)xxx$#>Delete</div>
            <div id=xxx$#btn_91.0xxx$# class=xxx$#open_button col-lg-12 col-xlg-12 col-md-12 xxx$# style=xxx$#text-align: center;xxx$#> 
                <a   onclick=xxx$#showAnswer_20(xxxn4$#copyxxxn4$#)xxx$#   href=xxx$##xxx$# contenteditable=xxx$#truexxx$# class=xxx$#btn btn-info btn-rounded waves-effect waves-light xxx$#>Copy and share link </a>

            </div>
        </div>
        <div class=xxx$#drop-indicatorxxx$#></div>
    </div>
</div>











<div id=xxx$#my_funnel_footerxxx$# class=xxx$# open_policy row margen_non  draggablexxx$# draggable=xxx$#truexxx$#>

    <div id=xxx$#xxx$# class=xxx$# col-lg-12 col-xlg-12 col-md-12 xxx$# style=xxx$#text-align: center;xxx$#>
        <a id=xxx$#impressxxx$# href=xxx$#https://qualityfriend.solutions/xxx$#>Impressum</a>  | 
        <a id=xxx$#data_policyxxx$# href=xxx$#https://qualityfriend.solutions/xxx$#>Datenschutzerklärung</a>
    </div> 
    <div id=xxx$#xxx$# class=xxx$#qf col-lg-12 col-xlg-12 col-md-12 xxx$# style=xxx$#text-align: center;xxx$#>
        <a href=xxx$#https://qualityfriend.solutions/xxx$#>⚡️ by Qualityfriend</a>  
    </div> 
</div>                                    </div>';


$pages = ["Advantages", "Company / Tasks", "1. Question: Do you have experience in the field of XY?","2. Question: What is important to you in a new job?","3. Question: How many years of work experience do you have?","4. Question: Describe yourself in three or four short sentences?","5. Question: When could you start with us?","6. Upload CV","7. When is the earliest we can reach you?","Data Entry"];
$what = "";
if(isset($_POST['code'])){
    $code = $_POST['code'];
    $code =  str_replace('"',"xxx$#",$code);
    $code =  str_replace("'","xxxn4$#",$code);
}
$id = 0;
if(isset($_POST['id'])){
    $id = $_POST['id'];
}

if(isset($_POST['what'])){
    $what = $_POST['what'];
}
if(isset($_POST['name'])){
    $name = $_POST['name'];
}
if(isset($_POST['pages'])){
    $pages = $_POST['pages'];
}
if(isset($_POST['funnel_name'])){
    $funnel_name = $_POST['funnel_name'];
}



$entryby_id=$user_id;
$entryby_ip=getIPAddress();
$entry_time=date("Y-m-d H:i:s");
$last_editby_id=$user_id;
$last_editby_ip=getIPAddress();
$last_edit_time=date("Y-m-d H:i:s");


if($what == "create"){
    $pagesJSON = json_encode($pages);
    $sql = "INSERT INTO `tbl_funnel_info`( `hotel_id`, `user_id`, `name`, `url`, `code`, `pages_array`, `create_at`, `update_at`) VALUES ('$hotel_id','$user_id','$name','','$code','$pagesJSON','$entry_time','$entry_time')";

}else{

    $sql="UPDATE `tbl_funnel_info` SET `name`='$funnel_name', `code`='$code',`pages_array`= '$pages',`update_at` = '$entry_time'   WHERE `f_id` =  $id";
}
$result = $conn->query($sql);
if($result){
    if($id == 0){
        $last_id = $conn->insert_id;
        echo $last_id;
    }else {
        echo $id;
    }


}else{
    echo "error";
}






?>