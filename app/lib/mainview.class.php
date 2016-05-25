<?php 
	/**
	* Classe MainView com métodos comuns
	*/
	class MainView{
		/**
		* Método para adicionar mensagem ao buffer
		* @param msg, string mensagem para ser adicionada
		* @param type, string success ou error 
		*/
		public function newMessage($msg, $type){
			global $msgPool;
			if(!is_array($msgPool)){
				$msgPool = array();
			}

			$messages = array(
				'msg'  => $msg,
				'type' => $type
			);

			array_push($msgPool, $messages);
		}

		/**
		* Escreve a mesagem que contem na var global msgPool
		*/
		function showMessages(){
			global $msgPool;
			if(is_array($msgPool) && !empty($msgPool)){
				foreach ($msgPool as $msg) {
					echo '<div class="container">
							<div class="'.$msg['type'].'">'
							.$msg['msg'].
							'<span>x</span>
							</div>
						</div>';
				}
			}
		}
	}