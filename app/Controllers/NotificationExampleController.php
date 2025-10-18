<?php

namespace App\Controllers;

use App\Libraries\FirebaseNotificationService;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Example Controller demonstrating Push Notification Integration
 * 
 * This shows how to send push notifications in various scenarios
 */
class NotificationExampleController extends BaseController
{
    protected $firebase;

    public function __construct()
    {
        helper('notification');
        $this->firebase = new FirebaseNotificationService();
    }

    /**
     * Example 1: Send notification when a request is assigned
     */
    public function onRequestAssigned($requestId, $assignedToUserId)
    {
        // Method 1: Using helper function (recommended)
        $result = send_push_notification(
            $assignedToUserId,
            'New Request Assigned',
            "Request #{$requestId} has been assigned to you",
            [
                'url' => "/requests/{$requestId}",
                'request_id' => (string)$requestId,
                'type' => 'request_assigned'
            ]
        );

        if ($result['success']) {
            log_message('info', "Push notification sent to user {$assignedToUserId} for request {$requestId}");
        }

        return $result;
    }

    /**
     * Example 2: Send notification to multiple users (team notification)
     */
    public function notifyTeam($teamUserIds, $message)
    {
        // Method 2: Using helper for multiple users
        $result = send_push_notification_to_multiple(
            $teamUserIds,
            'Team Announcement',
            $message,
            [
                'type' => 'team_announcement',
                'url' => '/dashboard'
            ]
        );

        return $result;
    }

    /**
     * Example 3: Send notification when request status changes
     */
    public function onRequestStatusChange($requestId, $userId, $newStatus)
    {
        // Method 3: Using the service directly
        $statusMessages = [
            'approved' => 'Your request has been approved',
            'rejected' => 'Your request has been rejected',
            'pending' => 'Your request is pending review'
        ];

        $message = $statusMessages[$newStatus] ?? 'Your request status has changed';

        $result = $this->firebase->sendToUser(
            $userId,
            'Request Status Update',
            $message,
            [
                'url' => "/requests/{$requestId}",
                'request_id' => (string)$requestId,
                'status' => $newStatus,
                'type' => 'request_status_change'
            ]
        );

        return $result;
    }

    /**
     * Example 4: Send notification to user when mentioned in a comment
     */
    public function onUserMentioned($mentionedUserId, $mentionerName, $context)
    {
        $result = send_push_notification(
            $mentionedUserId,
            'You were mentioned',
            "{$mentionerName} mentioned you in a comment",
            [
                'type' => 'mention',
                'url' => $context['url'] ?? '/notifications'
            ]
        );

        return $result;
    }

    /**
     * Example 5: Send notification for visitor enrollment
     */
    public function onVisitorEnrolled($visitorId, $approverUserId)
    {
        $result = send_push_notification(
            $approverUserId,
            'Visitor Enrollment Request',
            "A new visitor #{$visitorId} has been submitted for enrollment approval",
            [
                'url' => "/visitors/{$visitorId}",
                'visitor_id' => (string)$visitorId,
                'type' => 'visitor_enrollment'
            ]
        );

        return $result;
    }

    /**
     * Example 6: Send notification when user has pending approvals
     */
    public function notifyPendingApprovals($userId, $pendingCount)
    {
        $result = send_push_notification(
            $userId,
            'Pending Approvals',
            "You have {$pendingCount} pending approval" . ($pendingCount > 1 ? 's' : ''),
            [
                'url' => '/requests?status=pending',
                'count' => (string)$pendingCount,
                'type' => 'pending_approvals'
            ]
        );

        return $result;
    }

    /**
     * Example 7: Broadcast notification to all users with device tokens
     */
    public function broadcastAnnouncement($title, $message, $url = '/dashboard')
    {
        $userModel = new \Myth\Auth\Models\UserModel();
        
        // Get all users with device tokens
        $users = $userModel->where('device_token IS NOT NULL')
                          ->where('active', 1)
                          ->findAll();

        $userIds = array_column($users, 'id');

        if (empty($userIds)) {
            return [
                'success' => false,
                'error' => 'No users with device tokens found'
            ];
        }

        $result = send_push_notification_to_multiple(
            $userIds,
            $title,
            $message,
            [
                'url' => $url,
                'type' => 'broadcast'
            ]
        );

        return $result;
    }

    /**
     * Example 8: Send notification with badge count
     */
    public function sendWithBadge($userId, $unreadCount)
    {
        // For iOS, you might want to include badge count
        $result = $this->firebase->sendToUser(
            $userId,
            'New Notification',
            "You have {$unreadCount} unread notification" . ($unreadCount > 1 ? 's' : ''),
            [
                'badge' => (string)$unreadCount,
                'url' => '/notifications',
                'type' => 'unread_notifications'
            ]
        );

        return $result;
    }

    /**
     * Example 9: Schedule reminder notification
     * (You would typically use this with a CRON job or scheduled task)
     */
    public function sendReminder($userId, $reminderText, $targetUrl)
    {
        $result = send_push_notification(
            $userId,
            'Reminder',
            $reminderText,
            [
                'url' => $targetUrl,
                'type' => 'reminder',
                'timestamp' => date('Y-m-d H:i:s')
            ]
        );

        return $result;
    }

    /**
     * Example 10: Test endpoint to manually trigger a notification
     * (Remove this in production or protect it with admin-only access)
     */
    public function testSend()
    {
        $userId = $this->request->getGet('user_id');
        
        if (!$userId) {
            return $this->response->setJSON([
                'success' => false,
                'error' => 'user_id parameter is required'
            ]);
        }

        $result = send_push_notification(
            $userId,
            'Test Notification',
            'This is a test notification from the Islanders Finolhu system',
            [
                'test' => 'true',
                'url' => '/dashboard',
                'timestamp' => date('Y-m-d H:i:s')
            ]
        );

        return $this->response->setJSON($result);
    }
}
