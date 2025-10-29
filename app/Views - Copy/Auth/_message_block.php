<?php if (session()->has('message')) : ?>
	<div class="alert alert-success d-flex align-items-center p-5 mb-10">
		<!--begin::Icon-->
		<i class="ki-duotone ki-shield-tick fs-2hx text-success me-4">
			<span class="path1"></span>
			<span class="path2"></span>
		</i>
		<!--end::Icon-->
		<!--begin::Wrapper-->
		<div class="d-flex flex-column">
			<h4 class="mb-1 text-dark">Success</h4>
			<span><?= session('message') ?></span>
		</div>
		<!--end::Wrapper-->
	</div>
<?php endif ?>

<?php if (session()->has('error')) : ?>
	<div class="alert alert-danger d-flex align-items-center p-5 mb-10">
		<!--begin::Icon-->
		<i class="ki-duotone ki-information-5 fs-2hx text-danger me-4">
			<span class="path1"></span>
			<span class="path2"></span>
			<span class="path3"></span>
		</i>
		<!--end::Icon-->
		<!--begin::Wrapper-->
		<div class="d-flex flex-column">
			<h4 class="mb-1 text-dark">Error</h4>
			<span><?= session('error') ?></span>
		</div>
		<!--end::Wrapper-->
	</div>
<?php endif ?>

<?php if (session()->has('errors')) : ?>
	<div class="alert alert-danger d-flex align-items-center p-5 mb-10">
		<!--begin::Icon-->
		<i class="ki-duotone ki-information-5 fs-2hx text-danger me-4">
			<span class="path1"></span>
			<span class="path2"></span>
			<span class="path3"></span>
		</i>
		<!--end::Icon-->
		<!--begin::Wrapper-->
		<div class="d-flex flex-column">
			<h4 class="mb-1 text-dark">Please correct the following errors:</h4>
			<ul class="mb-0">
			<?php foreach (session('errors') as $error) : ?>
				<li><?= $error ?></li>
			<?php endforeach ?>
			</ul>
		</div>
		<!--end::Wrapper-->
	</div>
<?php endif ?>
