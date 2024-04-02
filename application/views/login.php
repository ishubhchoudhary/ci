<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
       <!-- <?php $ci =& get_instance(); if($ci->session->flashdata('success')){ ?>
        <div class="alert alert-success alert-dismissible fade show">
            <p class="mb-0 pb-0"><?php echo $ci->session->flashdata('success'); ?></p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>

        <?php if($ci->session->flashdata('error')){ ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <p class="mb-0 pb-0"><?php echo $ci->session->flashdata('error'); ?></p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?> -->
        <?php echo message(); ?>
        
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Login</h1>
                    <form action="{{ route('account.authenticate') }}" method="post">
                       
                        <div class="mb-3">
                            <label for="" class="mb-2">Email*</label>
                            <input type="text" name="email" value="" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="example@example.com">
                           
                            <!-- @error('email')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror -->

                        </div> 
                        <div class="mb-3">
                            <label for="" class="mb-2">Password*</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter Password">
                            
                            <!-- @error('password')
                            <p class="invalid-feedback">{{ $message }}</p>
                            @enderror -->
                            
                        </div> 
                        <div class="justify-content-between d-flex">
                        <button class="btn btn-primary mt-2">Login</button>
                            <!-- <a href="forgot-password.html" class="mt-3">Forgot Password?</a> -->
                        </div>
                    </form>                    
                </div>
                <div class="mt-4 text-center">
                    <p>Do not have an account? <a  href="<?php echo base_url(); ?>register">Register</a></p>
                </div>
            </div>
        </div>
        <!-- <div class="py-lg-5">&nbsp;</div> -->
    </div>
</section>

