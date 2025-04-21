import 'package:flutter/material.dart';

class MainScreen extends StatelessWidget {
  const MainScreen({super.key}); // Updated to use super.key syntax

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Voting App')),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            ElevatedButton(
              onPressed: () => Navigator.pushNamed(context, '/register'),
              style: ElevatedButton.styleFrom(
                padding: const EdgeInsets.symmetric(
                  horizontal: 40,
                  vertical: 15,
                ),
                minimumSize: const Size(200, 50), // Added minimum size
              ),
              child: const Text('Register', style: TextStyle(fontSize: 18)),
            ),
            const SizedBox(height: 20),
            ElevatedButton(
              onPressed: () => Navigator.pushNamed(context, '/results'),
              style: ElevatedButton.styleFrom(
                padding: const EdgeInsets.symmetric(
                  horizontal: 40,
                  vertical: 15,
                ),
                minimumSize: const Size(200, 50), // Added minimum size
              ),
              child: const Text('View Results', style: TextStyle(fontSize: 18)),
            ),
          ],
        ),
      ),
    );
  }
}
