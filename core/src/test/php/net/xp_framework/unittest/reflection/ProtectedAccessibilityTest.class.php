<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'lang.ClassLoader',
    'net.xp_framework.unittest.reflection.ProtectedAccessibilityFixture',
    'net.xp_framework.unittest.reflection.ProtectedAccessibilityFixtureChild'
  );

  /**
   * TestCase
   *
   * @see      xp://lang.reflect.Constructor
   * @see      xp://lang.reflect.Method
   * @see      xp://lang.reflect.Field
   */
  class ProtectedAccessibilityTest extends TestCase {
    protected static 
      $fixture        = NULL, 
      $fixtureChild   = NULL;
    
    /**
     * Initialize fixture and fixtureChild members
     *
     */
    #[@beforeClass]
    public static function initializeClasses() {
      self::$fixture= XPClass::forName('net.xp_framework.unittest.reflection.ProtectedAccessibilityFixture');
      self::$fixtureChild= XPClass::forName('net.xp_framework.unittest.reflection.ProtectedAccessibilityFixtureChild');
    }

    /**
     * Invoke protected constructor from here should not work
     *
     */
    #[@test, @expect('lang.IllegalAccessException')]
    public function invokingProtectedConstructor() {
      self::$fixture->getConstructor()->newInstance(array());
    }
  
    /**
     * Invoke protected constructor from same class
     *
     */
    #[@test]
    public function invokingProtectedConstructorFromSameClass() {
      $this->assertInstanceOf(self::$fixture, ProtectedAccessibilityFixture::construct(self::$fixture));
    }

    /**
     * Invoke protected constructor from parent class
     *
     */
    #[@test]
    public function invokingProtectedConstructorFromParentClass() {
      $this->assertInstanceOf(self::$fixture, ProtectedAccessibilityFixtureChild::construct(self::$fixture));
    }

    /**
     * Invoke protected constructor from child class
     *
     */
    #[@test]
    public function invokingProtectedConstructorFromChildClass() {
      $this->assertInstanceOf(self::$fixtureChild, ProtectedAccessibilityFixtureChild::construct(self::$fixtureChild));
    }

    /**
     * Invoke protected constructor from here should work if it's accessible
     *
     */
    #[@test]
    public function invokingProtectedConstructorMadeAccessible() {
      $this->assertInstanceOf(self::$fixture, self::$fixture
        ->getConstructor()
        ->setAccessible(TRUE)
        ->newInstance(array())
      );
    }

    /**
     * Invoke protected method from here should not work
     *
     */
    #[@test, @expect('lang.IllegalAccessException')]
    public function invokingProtectedMethod() {
      self::$fixture->getMethod('target')->invoke(ProtectedAccessibilityFixture::construct(self::$fixture));
    }

    /**
     * Invoke protected method from same class
     *
     */
    #[@test]
    public function invokingProtectedMethodFromSameClass() {
      $this->assertEquals('Invoked', ProtectedAccessibilityFixture::invoke(self::$fixture));
    }

    /**
     * Invoke protected method from parent class
     *
     */
    #[@test]
    public function invokingProtectedMethodFromParentClass() {
      $this->assertEquals('Invoked', ProtectedAccessibilityFixtureChild::invoke(self::$fixture));
    }

    /**
     * Invoke protected method from child class
     *
     */
    #[@test]
    public function invokingProtectedMethodFromChildClass() {
      $this->assertEquals('Invoked', ProtectedAccessibilityFixtureChild::invoke(self::$fixtureChild));
    }

    /**
     * Invoke protected method from here should work if it's accessible
     *
     */
    #[@test]
    public function invokingProtectedMethodMadeAccessible() {
      $this->assertEquals('Invoked', self::$fixture
        ->getMethod('target')
        ->setAccessible(TRUE)
        ->invoke(ProtectedAccessibilityFixture::construct(self::$fixture))
      );
    }

    /**
     * Invoke protected method from here should not work
     *
     */
    #[@test, @expect('lang.IllegalAccessException')]
    public function invokingProtectedStaticMethod() {
      self::$fixture->getMethod('staticTarget')->invoke(NULL);
    }

    /**
     * Invoke protected method from same class
     *
     */
    #[@test]
    public function invokingProtectedStaticMethodFromSameClass() {
      $this->assertEquals('Invoked', ProtectedAccessibilityFixture::invokeStatic(self::$fixture));
    }

    /**
     * Invoke protected method from same class
     *
     */
    #[@test]
    public function invokingProtectedStaticMethodFromParentClass() {
      $this->assertEquals('Invoked', ProtectedAccessibilityFixtureChild::invokeStatic(self::$fixture));
    }

    /**
     * Invoke protected method from same class
     *
     */
    #[@test]
    public function invokingProtectedStaticMethodFromChildClass() {
      $this->assertEquals('Invoked', ProtectedAccessibilityFixtureChild::invokeStatic(self::$fixtureChild));
    }

    /**
     * Invoke protected method from here should work if it's accessible
     *
     */
    #[@test]
    public function invokingProtectedStaticMethodMadeAccessible() {
      $this->assertEquals('Invoked', self::$fixture
        ->getMethod('staticTarget')
        ->setAccessible(TRUE)
        ->invoke(NULL)
      );
    }

    /**
     * Read protected member from here should not work
     *
     */
    #[@test, @expect('lang.IllegalAccessException')]
    public function readingProtectedMember() {
      self::$fixture->getField('target')->get(ProtectedAccessibilityFixture::construct(self::$fixture));
    }

    /**
     * Read protected member from same class
     *
     */
    #[@test]
    public function readingProtectedMemberFromSameClass() {
      $this->assertEquals('Target', ProtectedAccessibilityFixture::read(self::$fixture));
    }

    /**
     * Read protected member from same class
     *
     */
    #[@test]
    public function readingProtectedMemberFromParentClass() {
      $this->assertEquals('Target', ProtectedAccessibilityFixtureChild::read(self::$fixture));
    }

    /**
     * Read protected member from same class
     *
     */
    #[@test]
    public function readingProtectedMemberFromChildClass() {
      $this->assertEquals('Target', ProtectedAccessibilityFixtureChild::read(self::$fixtureChild));
    }

    /**
     * Read protected member from here should work if it's accessible
     *
     */
    #[@test]
    public function readingProtectedMemberMadeAccessible() {
      $this->assertEquals('Target', self::$fixture
        ->getField('target')
        ->setAccessible(TRUE)
        ->get(ProtectedAccessibilityFixture::construct(self::$fixture))
      );
    }

    /**
     * Read protected member from here should not work
     *
     */
    #[@test, @expect('lang.IllegalAccessException')]
    public function readingProtectedStaticMember() {
      self::$fixture->getField('staticTarget')->get(NULL);
    }

    /**
     * Read protected static member from same class
     *
     */
    #[@test]
    public function readingProtectedStaticMemberFromSameClass() {
      $this->assertEquals('Target', ProtectedAccessibilityFixture::readStatic(self::$fixture));
    }

    /**
     * Read protected static member from same class
     *
     */
    #[@test]
    public function readingProtectedStaticMemberFromParentClass() {
      $this->assertEquals('Target', ProtectedAccessibilityFixtureChild::readStatic(self::$fixture));
    }

    /**
     * Read protected static member from same class
     *
     */
    #[@test]
    public function readingProtectedStaticMemberFromChildClass() {
      $this->assertEquals('Target', ProtectedAccessibilityFixtureChild::readStatic(self::$fixtureChild));
    }

    /**
     * Read protected member from here should work if it's accessible
     *
     */
    #[@test]
    public function readingProtectedStaticMemberMadeAccessible() {
      $this->assertEquals('Target', self::$fixture
        ->getField('staticTarget')
        ->setAccessible(TRUE)
        ->get(NULL)
      );
    }

    /**
     * Write protected member from here should not work
     *
     */
    #[@test, @expect('lang.IllegalAccessException')]
    public function writingProtectedMember() {
      self::$fixture->getField('target')->set(ProtectedAccessibilityFixture::construct(self::$fixture), NULL);
    }

    /**
     * Write protected member from same class
     *
     */
    #[@test]
    public function writingProtectedMemberFromSameClass() {
      $this->assertEquals('Modified', ProtectedAccessibilityFixture::write(self::$fixture));
    }

    /**
     * Write protected member from same class
     *
     */
    #[@test]
    public function writingProtectedMemberFromParentClass() {
      $this->assertEquals('Modified', ProtectedAccessibilityFixtureChild::write(self::$fixture));
    }

    /**
     * Write protected member from same class
     *
     */
    #[@test]
    public function writingProtectedMemberFromChildClass() {
      $this->assertEquals('Modified', ProtectedAccessibilityFixtureChild::write(self::$fixtureChild));
    }

    /**
     * Write protected member from here should work if it's accessible
     *
     */
    #[@test]
    public function writingProtectedMemberMadeAccessible() {
      with ($f= self::$fixture->getField('target'), $i= ProtectedAccessibilityFixture::construct(self::$fixture)); {
        $f->setAccessible(TRUE);
        $f->set($i, 'Modified');
        $this->assertEquals('Modified', $f->get($i));
      }
    }

    /**
     * Write protected static member from same class
     *
     */
    #[@test, @expect('lang.IllegalAccessException')]
    public function writingProtectedStaticMember() {
      self::$fixture->getField('staticTarget')->set(NULL, 'Modified');
    }

    /**
     * Write protected static member from same class
     *
     */
    #[@test]
    public function writingProtectedStaticMemberFromSameClass() {
      $this->assertEquals('Modified', ProtectedAccessibilityFixture::writeStatic(self::$fixture));
    }

    /**
     * Write protected static member from same class
     *
     */
    #[@test]
    public function writingProtectedStaticMemberFromParentClass() {
      $this->assertEquals('Modified', ProtectedAccessibilityFixtureChild::writeStatic(self::$fixture));
    }

    /**
     * Write protected static member from same class
     *
     */
    #[@test]
    public function writingProtectedStaticMemberFromChildClass() {
      $this->assertEquals('Modified', ProtectedAccessibilityFixtureChild::writeStatic(self::$fixtureChild));
    }

    /**
     * Write protected member from here should work if it's accessible
     *
     */
    #[@test]
    public function writingProtectedStaticMemberMadeAccessible() {
      with ($f= self::$fixture->getField('staticTarget')); {
        $f->setAccessible(TRUE);
        $f->set(NULL, 'Modified');
        $this->assertEquals('Modified', $f->get(NULL));
      }
    }
  }
?>
