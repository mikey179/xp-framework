<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('io.streams.OutputStream', 'io.streams.Streams');

  /**
   * OuputStream that compresses content using bzip2
   *
   * @ext      bz2
   * @test     xp://net.xp_framework.unittest.io.streams.Bz2CompressingOutputStreamTest
   * @purpose  OuputStream implementation
   */
  class Bz2CompressingOutputStream extends Object implements OutputStream {
    protected $out= NULL;
    
    /**
     * Constructor
     *
     * @param   io.streams.OutputStream out
     * @param   int level default 6
     * @throws  lang.IllegalArgumentException if the level is not between 0 and 9
     */
    public function __construct(OutputStream $out, $level= 6) {
      if ($level < 0 || $level > 9) {
        throw new IllegalArgumentException('Level '.$level.' out of range [0..9]');
      }
      $this->out= Streams::writeableFd($out);
      if (!stream_filter_append($this->out, 'bzip2.compress', STREAM_FILTER_WRITE, array('blocks' => $level))) {
        fclose($this->out);
        $this->out= NULL;
        throw new IOException('Could not append stream filter');
      }
    }
    
    /**
     * Write a string
     *
     * @param   var arg
     */
    public function write($arg) {
      fwrite($this->out, $arg);
    }

    /**
     * Flush this buffer
     *
     */
    public function flush() {
      fflush($this->out);
    }

    /**
     * Close this buffer. Flushes this buffer and then calls the close()
     * method on the underlying OuputStream.
     *
     */
    public function close() {
      if (!$this->out) return;
      fclose($this->out);
      $this->out= NULL;
    }

    /**
     * Destructor. Ensures output stream is closed.
     *
     */
    public function __destruct() {
      $this->close();
    }
  }
?>
