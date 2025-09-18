<div class="analytics">

    <div class="card">
        <div class="card-head">
            <h2><?php echo $qty;?></h2>
            <span class="las la-user-friends"></span>
        </div>
        <div class="card-progress">
            <small>Nombre de personne ayant répondu à une enquête</small>
            <?php if(isset($_GET['zone']) && $_GET['zone'] != 'admin'){
                ?>
            
                    <div class="card-indicator">
                        <div class="indicator one" style="width: <?php echo $qty_pourcent;?>%"></div>
                    </div>
                <?php
            }
            ?>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <h2>340,230</h2>
            <span class="las la-eye"></span>
        </div>
        <div class="card-progress">
            <small>Page views</small>
            <div class="card-indicator">
                <div class="indicator two" style="width: 80%"></div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <h2>$653,200</h2>
            <span class="las la-shopping-cart"></span>
        </div>
        <div class="card-progress">
            <small>Monthly revenue growth</small>
            <div class="card-indicator">
                <div class="indicator three" style="width: 65%"></div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <h2>47,500</h2>
            <span class="las la-envelope"></span>
        </div>
        <div class="card-progress">
            <small>New E-mails received</small>
            <div class="card-indicator">
                <div class="indicator four" style="width: 90%"></div>
            </div>
        </div>
    </div>

</div>