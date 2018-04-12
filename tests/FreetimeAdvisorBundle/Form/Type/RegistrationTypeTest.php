<?php
// tests/AppBundle/Form/Type/TestedTypeTest.php
namespace Tests;

use FreetimeAdvisorBundle\Form\RegistrationType;
use Symfony\Component\Form\Test\TypeTestCase;
use FreetimeAdvisorBundle\Entity\User;
use FreetimeAdvisorBundle\Entity\City;

class RegistrationTypeTest extends DatabaseTest
{
  private $user;

  public function __construct($name = null, array $data = [], $dataName = '')
  {
    $this->user = new User($this->getConnection());
    parent::__construct($name, $data, $dataName);
  }

  /** @test */
  public function RegistrationType()
  {
    $formData = array(
      'test' => 'test',
      'test2' => 'test2',
    );

    $form = $this->createForm(RegistrationType::class, $this->user);


  }

  // public function testSubmitValidData()
  // {
  //   $formData = array(
  //     'test' => 'test',
  //     'test2' => 'test2',
  //   );
  //
  //   $objectToCompare = new TestObject();
  //   // $objectToCompare will retrieve data from the form submission; pass it as the second argument
  //   $form = $this->factory->create(TestedType::class, $objectToCompare);
  //
  //   $object = new TestObject();
  //   // ...populate $object properties with the data stored in $formData
  //
  //   // submit the data to the form directly
  //   $form->submit($formData);
  //
  //   $this->assertTrue($form->isSynchronized());
  //
  //   // check that $objectToCompare was modified as expected when the form was submitted
  //   $this->assertEquals($object, $objectToCompare);
  //
  //   $view = $form->createView();
  //   $children = $view->children;
  //
  //   foreach (array_keys($formData) as $key) {
  //     $this->assertArrayHasKey($key, $children);
  //   }
  // }
}
