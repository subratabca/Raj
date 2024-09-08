<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Models\Food;

class ClientNotificationController extends Controller
{
  public function MarkAsRead(Request $request)
  {
      try {
          $email = $request->header('email');
          if (!$email) {
              return response()->json([
                  'status' => 'error',
                  'message' => 'Email header is missing.'
              ], 400);
          }

          $user = User::where('email', $email)->first();
          if (!$user) {
              return response()->json([
                  'status' => 'error',
                  'message' => 'User not found.'
              ], 404);
          }

          $user->unreadNotifications->markAsRead();
          return response()->json([
              'status' => 'success',
              'message' => 'All notifications marked as read.'
          ], 200);

      } catch (\Exception $e) {
          return response()->json([
              'status' => 'error',
              'message' => 'An error occurred while marking notifications as read.',
              'error' => $e->getMessage(),
          ], 500);
      }
  }



  public function MarkAsReadByType(Request $request, $notificationId)
  {
      $email = $request->header('email');
      $user = User::where('email', $email)->first();

      $notification = $user->notifications()->where('id', $notificationId)->first();

      if ($notification && is_null($notification->read_at)) {
          $notification->markAsRead();
      }

      $notificationData = $notification->data;
      if (is_string($notificationData)) {
          $notificationData = json_decode($notificationData, true);
      }

      if (!is_array($notificationData)) {
          $notificationData = [];
      }

      $type = isset($notificationData['data']) ? $notificationData['data'] : 'Unknown Type';
      return view('client.pages.dashboard.notification-details-page', compact('type'));
  }


  public function NotificationDetailsById(Request $request, $notificationId)
  {
      try {
          $email = $request->header('email');
          $user = User::where('email', $email)->first();

          if (!$user) {
              return response()->json([
                  'status' => 'failed to fetch user',
                  'message' => 'User not found.',
              ], 404);
          }

          $notification = $user->notifications()->where('id', $notificationId)->first();

          if (!$notification) {
              return response()->json([
                  'status' => 'failed to fetch notification',
                  'message' => 'Notification not found.',
              ], 404);
          }

          $notificationData = $notification->data;
          if (is_string($notificationData)) {
              $notificationData = json_decode($notificationData, true);
          }

          if (!is_array($notificationData)) {
              return response()->json([
                  'status' => 'failed',
                  'message' => 'Invalid notification data format.',
              ], 400);
          }

          if (!isset($notificationData['food_id'])) {
              return response()->json([
                  'status' => 'failed',
                  'message' => 'Food ID not found in the notification data.',
              ], 400);
          }


          $NotificationType = isset($notificationData['data']) ? $notificationData['data'] : 'Unknown Type';
          $food = Food::with('user','order','order.user')->find($notificationData['food_id']);

          if (!$food) {
              return response()->json([
                  'status' => 'failed to fetch food',
                  'message' => 'Food details not found.',
              ], 404);
          }

          return response()->json([
              'status' => 'success',
              'food' => $food,
              'title' => $NotificationType,
          ], 200);

      } catch (\Exception $e) {
          return response()->json([
              'status' => 'failed',
              'message' => 'An error occurred while retrieving notification details.',
              'error' => $e->getMessage(),
          ], 500);
      }
  }


  public function deleteNotification($notificationId)
  {
      try {
          $email = $request->header('email');
          $user = User::where('email', $email)->first();

          if (!$user) {
               return response()->json([
                  'status' => 'failed to fetch user',
                  'message' => 'User not found.',
              ], 404);
          }

          $notification = $user->notifications()->find($notificationId);

          if ($notification) {
              $notification->delete();

              return response()->json([
                  'status' => 'success',
                  'message' => 'Notification deleted successfully',
              ], 200);
          } else {
              return response()->json([
                  'status' => 'failed',
                  'message' => 'Notification not found',
              ], 404);
          }
      } catch (Exception $e) {
          return response()->json([
              'status' => 'failed',
              'message' => 'An error occurred while deleting the notification: ' . $e->getMessage(),
          ], 500);
      }
  }




}