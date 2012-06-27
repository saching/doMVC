        
<h2>Contact Us</h2>    	

</div><!--end frontpage-info-->    	

<div id="featured-projects">   	

    <?php if ($status == null || strlen($status) < 1) { ?>
        <form action="/contact" method="post"  class="well" >
            <?php printCsrfToken(); ?>
            <div>
                <label>Name*:</label>
                <?php field_input("name", array('class' => "span3", 'type' => 'text', 'placeholder' => "Type your name here ...")); ?>
                <?php printError($error, 'name') ?>                    
            </div>
            <div>
                <label>Email*:</label>
                <?php field_input("email", array('placeholder' => 'my@gmail.com', 'class' => "span3", 'type' => 'text')); ?>
                <?php printError($error, 'email') ?>                    
            </div>
            <div>
                <label>Comments:</label>
                <textarea name="comments" class="input-xlarge" ></textarea>                    
            </div>
            <div class="button">
                <input type="submit" value="Send" class="btn btn-primary" />
            </div>
        </form>
        <?php
    } else {
        echo $status;
    }
    ?>