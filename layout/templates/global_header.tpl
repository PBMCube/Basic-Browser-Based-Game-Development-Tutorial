<!DOCTYPE html>
<html>
  <head>
    <title>Wizarding World</title>
    <!-- Latest Bootstrap -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/latest/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <br/><br/>
      <div style="text-align:center;margin-bottom:20px;">
        <img src="http://forums.makingbrowsergames.com/logo3.png"/>
      </div>
      <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
          {include file="sidebar.tpl"}
        </div>
        <!-- Content -->
        <div class="col-md-9">
          {if $error}
            <div class="alert alert-danger">{$error}</div>
          {/if}
          {if $success}
            <div class="alert alert-success">{$success}</div>
          {/if}
          <div class="panel panel-default">
            <div class="panel-body">