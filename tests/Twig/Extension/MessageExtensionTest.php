<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Tests\Twig\Extension;

use FOS\MessageBundle\Twig\MessageExtension;
use PHPUnit\Framework\TestCase;

/**
 * Testfile for MessageExtension.
 */
class MessageExtensionTest extends TestCase
{
    private $extension;
    private $participantProvider;
    private $provider;
    private $authorizer;
    private $participant;

    public function setUp(): void
    {
        $this->participantProvider = $this->getMockBuilder('FOS\MessageBundle\Security\ParticipantProviderInterface')->getMock();
        $this->provider = $this->getMockBuilder('FOS\MessageBundle\Provider\ProviderInterface')->getMock();
        $this->authorizer = $this->getMockBuilder('FOS\MessageBundle\Security\AuthorizerInterface')->getMock();
        $this->participant = $this->getMockBuilder('FOS\MessageBundle\Model\ParticipantInterface')->getMock();
        $this->extension = new MessageExtension($this->participantProvider, $this->provider, $this->authorizer);
    }

    public function testIsReadReturnsTrueWhenRead()
    {
        $this->participantProvider->expects($this->once())->method('getAuthenticatedParticipant')->will($this->returnValue($this->participant));
        $readAble = $this->getMockBuilder('FOS\MessageBundle\Model\ReadableInterface')->getMock();
        $readAble->expects($this->once())->method('isReadByParticipant')->with($this->participant)->will($this->returnValue(true));
        $this->assertTrue($this->extension->isRead($readAble));
    }

    public function testIsReadReturnsFalseWhenNotRead()
    {
        $this->participantProvider->expects($this->once())->method('getAuthenticatedParticipant')->will($this->returnValue($this->participant));
        $readAble = $this->getMockBuilder('FOS\MessageBundle\Model\ReadableInterface')->getMock();
        $readAble->expects($this->once())->method('isReadByParticipant')->with($this->participant)->will($this->returnValue(false));
        $this->assertFalse($this->extension->isRead($readAble));
    }

    public function testCanDeleteThreadWhenHasPermission()
    {
        $thread = $this->getThreadMock();
        $this->authorizer->expects($this->once())->method('canDeleteThread')->with($thread)->will($this->returnValue(true));
        $this->assertTrue($this->extension->canDeleteThread($thread));
    }

    public function testCanDeleteThreadWhenNoPermission()
    {
        $thread = $this->getThreadMock();
        $this->authorizer->expects($this->once())->method('canDeleteThread')->with($thread)->will($this->returnValue(false));
        $this->assertFalse($this->extension->canDeleteThread($thread));
    }

    public function testIsThreadDeletedByParticipantWhenDeleted()
    {
        $thread = $this->getThreadMock();
        $this->participantProvider->expects($this->once())->method('getAuthenticatedParticipant')->will($this->returnValue($this->participant));
        $thread->expects($this->once())->method('isDeletedByParticipant')->with($this->participant)->will($this->returnValue(true));
        $this->assertTrue($this->extension->isThreadDeletedByParticipant($thread));
    }

    public function testGetNbUnreadCacheStartsEmpty()
    {
        /*
         * assertAttributeEmpty is deprecated, see deprecated https://github.com/sebastianbergmann/phpunit/issues/3338
         */
//        if (\method_exists($this, 'assertAttributeEmpty')) {
//            $this->assertAttributeEmpty('nbUnreadMessagesCache', $this->extension);
//        }
        $this->assertEmpty($this->extension->getNbUnread());
        $this->extension->getNbUnread();
    }

    public function testGetNbUnread()
    {
        /*
         * assertAttributeEmpty is deprecated, see deprecated https://github.com/sebastianbergmann/phpunit/issues/3338
         */
//        if (\method_exists($this, 'assertAttributeEmpty')) {
//            $this->assertAttributeEmpty('nbUnreadMessagesCache', $this->extension);
//        }
        $this->assertEmpty($this->extension->getNbUnread());
        $this->provider->expects($this->once())->method('getNbUnreadMessages')->will($this->returnValue(3));
        $this->assertEquals(3, $this->extension->getNbUnread());
    }

    public function testGetNbUnreadStoresCache()
    {
        $this->provider->expects($this->once())->method('getNbUnreadMessages')->will($this->returnValue(3));
        //we call it twice but expect to only get one call
        $this->extension->getNbUnread();
        $this->extension->getNbUnread();
    }

    public function testGetName()
    {
        $this->assertEquals('fos_message', $this->extension->getName());
    }

    protected function getThreadMock()
    {
        return $this->getMockBuilder('FOS\MessageBundle\Model\ThreadInterface')->getMock();
    }
}
