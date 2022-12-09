<?php
require_once 'log.php';

	class Database {
		private $ctr;    //connect string
		private $driver;
		private $host;
		private $port;
		private $sid;
		private $conn;   //�s�u����
		private $rs;    //Recordset

		private $where;    //sql��where�l�y
		private $table;
		private $fields;    //select�l�y�Ψ쪺���W
		private $values;    //insert�l�y�Ψ쪺��
		private $orderby;     //select�l�y�Ψ쪺order by
		private $fieldName = array();			//sql�l�y���W��
		private $sqlStmt;      //sql�l�y
		private $sqlResult = array();      //sql�l�y���浲�G

		private $numrows;    //���X����
		private $offset;     //�����q
		private $totRec;     //�`����
		private $totPage;   //�`���� = ceil(�`���� / 10)
		private $curPage;    //�ثe���X
		private $firstPage;     //�_�l���X
		private $lastPage;     //�������X

		//�w�q�غc��k
		public function __construct($drive, $host, $port, $sid) {
			$this->driver = $drive;
			$this->host = $host;
			$this->port = $port;
			$this->sid = $sid;
			
			//�w�]��
		}
	
		//�w�q�Ѻc��k
		public function __destruct() {
			$this->rs->Close();
			$this->conn->Close();    //optional
		}
	
		public function initDB($usr, $pwd) {
			try {
				$ADODB_FETCH_MODE = ADODB_FETCH_NUM;
				$ADODB_COUNTRECS = false;
				//�s����Ʈw���e���]�wGlobal�ܼ�
				$this->conn = &ADONEWConnection($this->driver);
				$this->conn->debug = false;
				$this->conn->connectSID = true;
				$this->ctr = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST= '.$this->host.' )(PORT= '.$this->port.' ))(CONNECT_DATA=(SID= '.$this->sid.' )))';
				
				$this->conn->Connect($this->ctr, $usr, $pwd);
			} catch(exception $e) {
				//var_dump($e);
				//adodb_backtrace($e->gettrace());
				echo 'Database connect error!';
			}
		}

		private function setWhere($where) {
			$this->where = $where;
		}
		
		public function selStmt($table, $fields, $where, $orderby) {    //Select�ԭz�y
			$this->setWhere($where);  //���]�wwhere�l�y
			$this->table = $table;
			$this->fields = $fields;
			$this->orderby = $orderby;
			$this->sqlStmt = 'select '.$this->fields.' from '.$this->table.' '.$this->where.' '.$this->orderby;
			
			// $log   = new Log();
			// $log->write($this->sqlStmt, "BeanCode");

			$this->execSql();
			
			array_splice($this->sqlResult, 0);
			while (!$this->rs->EOF) {
				array_push($this->sqlResult, $this->rs->fields);
				$this->rs->MoveNext();
			}
			
			return $this->sqlResult;
		}
		
		private function execSql() {  //����sql�l�y
			$this->rs =& $this->conn->Execute($this->sqlStmt);
		}

		public function retSqlstmt() {  //�Ǧ^sqlStmt�ݩ�
			return $this->sqlStmt;
		}

		public function selLimit($table, $fields, $where, $orderby, $rows, $offset) {   //���X�@�w���ƪ��O��
			$this->setWhere($where);  //���]�wwhere�l�y
			$this->table = $table;
			$this->fields = $fields;
			$this->orderby = $orderby;
			$this->numrows = $rows;
			$this->offset = $offset;
			
			$this->sqlStmt = 'select '.$this->fields.' from '.$this->table.' '.$this->where.' '.$this->orderby;
			$this->execSql();
			
			$this->getRecCnt($this->sqlStmt);  //���D�X�`����
			$this->getTotPage();    //�D�`����
			$this->lastPage = (ceil($this->curPage / 10) * 10 < $this->totPage) ? ceil($this->curPage / 10) * 10 : $this->totPage;  //�D�������X
			$this->firstPage = ceil($this->lastPage / 10) * 10 - 9;  //�D�_�l���X
			
			$this->execSqlLimit();
			
			array_splice($this->sqlResult, 0);
			while (!$this->rs->EOF) {
				array_push($this->sqlResult, $this->rs->fields);
				$this->rs->MoveNext();
			}
			return $this->sqlResult;
		}

		private function execSqlLimit() {  //����selectLimit���X�@�w����
			$this->rs =& $this->conn->SelectLimit($this->sqlStmt, $this->numrows, $this->offset);
		}

		public function setCurPage($page) {   //�]�w�ثe���X
			$this->curPage = $page;
		}
		
		public function retCurPage() {   //�Ǧ^�ثe���X
			return $this->curPage;
		}
		
		public function retFirstPage() {   //�Ǧ^�_�l���X
			return $this->firstPage;
		}
		
		public function retLastPage() {   //�Ǧ^�������X
			return $this->lastPage;
		}
		
		private function getRecCnt($sql) {
			$this->totRec =& $this->rs->RecordCount($sql);
		}
		
		public function retTotRec() {  //�^���`����
			return $this->totRec;
		}
	
		private function getTotPage() {   //�D�`����
			$this->totPage = ceil($this->totRec / 10);
		}
	
		public function retTotPage() {   //�^���`����
			return $this->totPage;
		}

		public function retField() {   //�Ǧ^���W��
			array_splice($this->fieldName, 0);		
			for($i = 0; $i < $this->rs->FieldCount(); $i++) 
				$this->fieldName[$i] = $this->rs->FetchField($i);
				
			return $this->fieldName;
		}

		public function updStmt($table, $fields, $where) {    //Update�ԭz�y
			$this->setWhere($where);  //���]�wwhere�l�y
			$this->table = $table;
			$this->fields = $fields;
			$this->sqlStmt = 'update '.$this->table.' set '.$this->fields.' '.$this->where;
			$this->execSql();
		}
	
		public function insStmt($table, $fields, $values) {    //Insert into�ԭz�y
			$this->table = $table;
			$this->fields = $fields;
			$this->values = $values;
			$this->sqlStmt = 'insert into '.$this->table.' ('.$this->fields.') values('.$this->values.')';

			$log   = new Log();
			$log->write($this->sqlStmt, "BeanCode");
			
			$this->execSql();
		}
	
		public function delStmt($table, $where) {    //Delete�ԭz�y
			$this->setWhere($where);  //���]�wwhere�l�y
			$this->table = $table;
			$this->sqlStmt = '';			
			$this->sqlStmt = 'delete from '.$this->table.' '.$this->where;
			$this->execSql();
		}

	}
?>