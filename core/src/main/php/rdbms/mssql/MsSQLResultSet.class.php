<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('rdbms.ResultSet');

  /**
   * Result set
   *
   * @ext      mssql
   * @purpose  Resultset wrapper
   */
  class MsSQLResultSet extends ResultSet {
  
    /**
     * Constructor
     *
     * @param   resource handle
     */
    public function __construct($result, TimeZone $tz= NULL) {
      $fields= array();
      if (is_resource($result)) {
        for ($i= 0, $num= mssql_num_fields($result); $i < $num; $i++) {
          $field= mssql_fetch_field($result, $i);
          $fields[$field->name]= $field->type;
        }
      }
      parent::__construct($result, $fields, $tz);
    }

    /**
     * Seek
     *
     * @param   int offset
     * @return  bool success
     * @throws  rdbms.SQLException
     */
    public function seek($offset) { 
      if (!mssql_data_seek($this->handle, $offset)) {
        throw new SQLException('Cannot seek to offset '.$offset);
      }
      return TRUE;
    }
    
    /**
     * Iterator function. Returns a rowset if called without parameter,
     * the fields contents if a field is specified or FALSE to indicate
     * no more rows are available.
     *
     * @param   string field default NULL
     * @return  var
     */
    public function next($field= NULL) {
      if (
        !is_resource($this->handle) ||
        FALSE === ($row= mssql_fetch_assoc($this->handle))
      ) {
        return FALSE;
      }

      foreach ($row as $key => $value) {
        if (NULL === $value || !isset($this->fields[$key])) continue;
        
        switch ($this->fields[$key]) {
          case 'datetime': {
            $row[$key]= Date::fromString($value, $this->tz);
            break;
          }
          
          case 'numeric': {
            if (FALSE !== strpos($value, '.')) {
              settype($row[$key], 'double');
              break;
            }
            // Fallthrough intentional
          }
            
          case 'int': {
            if ($value <= LONG_MAX && $value >= LONG_MIN) {
              settype($row[$key], 'integer');
            } else {
              settype($row[$key], 'double');
            }
            break;
          }
          
        }
      }
      
      if ($field) return $row[$field]; else return $row;
    }

    /**
     * Close resultset and free result memory
     *
     * @return  bool success
     */
    public function close() { 
      if (!$this->handle) return;
      $r= mssql_free_result($this->handle);
      $this->handle= NULL;
      return $r;
    }
  }
?>
