<?php
  namespace Otserver;

  class Error_Critic {

    public function __construct($id = '', $text = '', $errors = array()) {
      print '<h3>Ocorreu um erro!</h3>';
      print 'ID do erro: <b>' . $id . '</b><br />';
      print 'Mais informações: <b>' . $text . '</b><br />';

      if (count($errors) > 0) {
        echo 'Lista de erros:<br />';
        foreach ($errors as $error)
          echo '<li>' . $error->getId() . ' - ' . $error->getText() . '</li>';
      }

      $showErrorBacktrace = function ($a, $b) {
        print "<br />Arquivo: <b>";
        if (isset($a['file'])) {
          print dirname($a['file']) . "/" . basename($a['file']);
        } else {
          print 'Desconhecido';
        }
        print "</b> &nbsp; Linha: <font color=\"red\">";
        print ((isset($a['line'])) ? $a['line'] : 'Desconhecido');
        print "</font>";
      };

      $tmp = debug_backtrace();
      array_walk($tmp, $showErrorBacktrace);
      exit;
    }

  }
