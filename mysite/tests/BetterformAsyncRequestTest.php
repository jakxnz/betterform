<?php


	class BetterformAsyncRequestTest extends SapphireTest {

		/**
		 * Test generation of the view
		 */
		public function testBasicView() {
			
			$response1 = Director::test('/api/check', array('email' => 'chris@taxtraders.co.nz'));
			$this->assertTrue(
					json_decode($response1->getBody())->return_code == 0,
					'Valid email test failed'
			);
	
			$response2 = Director::test('/api/check', array('email' => 'chris@taxtraders'));
			$this->assertEquals(
					json_decode($response2->getBody())->return_code,
					1, 
					'Invalid email test failed'
			);
	
			$response3 = Director::test('/api/check', array('name' => 'Test'));
			$this->assertTrue(
					json_decode($response3->getBody())->return_code == 0
					, 'Valid name test failed'
			);
	
			$response4 = Director::test('/api/check', array('name' => 'Test007'));
			$this->assertEquals(
					json_decode($response4->getBody())->return_code,
					1,
					'Invalid name test failed'
			);
	
		}
	}