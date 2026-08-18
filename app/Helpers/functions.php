<?php

use Illuminate\Support\Facades\DB;

/**
 * Inicializa a transação
 * @return void
 */
function beginTransaction() {
  DB::beginTransaction();
}

/**
 * Grava os dados da transaction
 * @return void
 */
function commit() {
  if (DB::transactionLevel()) {
    DB::commit();
  }
}

/**
 * Faz um rollback na transaction aberta
 * @return void
 */
function rollback() {
  if (DB::transactionLevel()) {
    DB::rollBack();
  }
}
